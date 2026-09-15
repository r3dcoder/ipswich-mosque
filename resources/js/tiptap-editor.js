/**
 * TipTap rich text editor for the Page Builder.
 *
 * Exposes window.PageBuilderEditor with:
 *   - create(selectorOrEl, options) -> editor instance
 *   - destroy(el)
 *   - getHtml(el)
 *   - setHtml(el, html)
 *   - uploadImage(file) -> Promise<url>
 */
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import Link from '@tiptap/extension-link';
import TextAlign from '@tiptap/extension-text-align';
import TextStyle from '@tiptap/extension-text-style';
import { Color } from '@tiptap/extension-color';
import Highlight from '@tiptap/extension-highlight';
import Placeholder from '@tiptap/extension-placeholder';
import Image from '@tiptap/extension-image';

const DEFAULT_UPLOAD_ENDPOINT = '/admin/editor/upload';

/** Registry of editors keyed by their container element */
const instances = new WeakMap();

/** All mounted editor containers (so we can tear them all down) */
const tracked = new Set();

/** Resolve the upload endpoint (can be overridden per page via window.PB_UPLOAD_URL) */
function uploadEndpoint() {
    return window.PB_UPLOAD_URL || DEFAULT_UPLOAD_ENDPOINT;
}

/**
 * Upload an image file to the server and resolve its public URL.
 */
export function uploadImage(file) {
    const formData = new FormData();
    formData.append('file', file);

    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';

    return fetch(uploadEndpoint(), {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
        body: formData,
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Image upload failed (' + response.status + ')');
            }
            return response.json();
        })
        .then((json) => json.location || json.url);
}

/**
 * TextAlign that also understands Quill 2.x markup (class="ql-align-center"),
 * so content created before the TipTap switch keeps its alignment.
 */
const QuillCompatibleTextAlign = TextAlign.extend({
    addGlobalAttributes() {
        return [
            {
                types: this.options.types,
                attributes: {
                    textAlign: {
                        default: this.options.defaultAlignment,
                        parseHTML: (element) => {
                            const fromStyle = element.style ? element.style.textAlign : '';

                            if (this.options.alignments.includes(fromStyle)) {
                                return fromStyle;
                            }

                            const classes = (element.getAttribute && element.getAttribute('class')) || '';
                            const fromQuill = classes.match(/ql-align-(left|center|right|justify)/);

                            if (fromQuill && this.options.alignments.includes(fromQuill[1])) {
                                return fromQuill[1];
                            }

                            return this.options.defaultAlignment;
                        },
                        renderHTML: (attributes) => {
                            if (!attributes.textAlign) {
                                return {};
                            }

                            return { style: `text-align: ${attributes.textAlign}` };
                        },
                    },
                },
            },
        ];
    },
});

/** Extended Image node with width + float (text wrap) attributes */
const ResizableImage = Image.extend({
    addAttributes() {
        return {
            ...this.parent?.(),
            width: {
                default: null,
                renderHTML: (attrs) => (attrs.width ? { style: `width:${attrs.width};height:auto;` } : {}),
            },
            float: {
                default: null,
                renderHTML: (attrs) => {
                    if (!attrs.float) return {};
                    const styles = {
                        left: 'float:left;margin:0 1rem 0.5rem 0;max-width:50%;',
                        right: 'float:right;margin:0 0 0.5rem 1rem;max-width:50%;',
                    };
                    return { style: styles[attrs.float] || '' };
                },
            },
        };
    },
});

/**
 * Build the toolbar DOM for an editor.
 */
function buildToolbar(editor) {
    const bar = document.createElement('div');
    bar.className = 'pb-toolbar flex flex-wrap items-center gap-1 p-2 border-b bg-gray-50';

    const btn = (label, title, action) => {
        const b = document.createElement('button');
        b.type = 'button';
        b.title = title;
        b.innerHTML = label;
        b.className =
            'pb-btn px-2 py-1 text-sm rounded border border-transparent text-gray-700 hover:bg-white hover:border-gray-300 transition-colors';
        b.addEventListener('click', (e) => {
            e.preventDefault();
            action();
        });
        return b;
    };

    const sep = () => {
        const s = document.createElement('span');
        s.className = 'w-px h-5 bg-gray-300 mx-1';
        return s;
    };

    const activeBtn = (label, title, isActiveFn, action) => {
        const b = btn(label, title, action);
        b._isActive = isActiveFn;
        return b;
    };

    // Headings + marks + lists + blocks
    bar.appendChild(activeBtn('<b>H1</b>', 'Heading 1', () => editor.isActive('heading', { level: 1 }), () => editor.chain().focus().toggleHeading({ level: 1 }).run()));
    bar.appendChild(activeBtn('<b>H2</b>', 'Heading 2', () => editor.isActive('heading', { level: 2 }), () => editor.chain().focus().toggleHeading({ level: 2 }).run()));
    bar.appendChild(activeBtn('<b>H3</b>', 'Heading 3', () => editor.isActive('heading', { level: 3 }), () => editor.chain().focus().toggleHeading({ level: 3 }).run()));
    bar.appendChild(sep());
    bar.appendChild(activeBtn('<b>B</b>', 'Bold', () => editor.isActive('bold'), () => editor.chain().focus().toggleBold().run()));
    bar.appendChild(activeBtn('<i>I</i>', 'Italic', () => editor.isActive('italic'), () => editor.chain().focus().toggleItalic().run()));
    bar.appendChild(activeBtn('<u>U</u>', 'Underline', () => editor.isActive('underline'), () => editor.chain().focus().toggleUnderline().run()));
    bar.appendChild(activeBtn('<s>S</s>', 'Strikethrough', () => editor.isActive('strike'), () => editor.chain().focus().toggleStrike().run()));
    bar.appendChild(sep());
    bar.appendChild(activeBtn('&bull; List', 'Bullet list', () => editor.isActive('bulletList'), () => editor.chain().focus().toggleBulletList().run()));
    bar.appendChild(activeBtn('1. List', 'Numbered list', () => editor.isActive('orderedList'), () => editor.chain().focus().toggleOrderedList().run()));
    bar.appendChild(sep());
    bar.appendChild(activeBtn('&ldquo;&rdquo;', 'Blockquote', () => editor.isActive('blockquote'), () => editor.chain().focus().toggleBlockquote().run()));
    bar.appendChild(activeBtn('&lt;/&gt;', 'Code block', () => editor.isActive('codeBlock'), () => editor.chain().focus().toggleCodeBlock().run()));
    bar.appendChild(btn('&mdash;', 'Horizontal rule', () => editor.chain().focus().setHorizontalRule().run()));
    bar.appendChild(sep());

    // Alignment
    bar.appendChild(activeBtn('&#8676;', 'Align left', () => editor.isActive({ textAlign: 'left' }), () => editor.chain().focus().setTextAlign('left').run()));
    bar.appendChild(activeBtn('&#8596;', 'Align center', () => editor.isActive({ textAlign: 'center' }), () => editor.chain().focus().setTextAlign('center').run()));
    bar.appendChild(activeBtn('&#8677;', 'Align right', () => editor.isActive({ textAlign: 'right' }), () => editor.chain().focus().setTextAlign('right').run()));
    bar.appendChild(sep());

    // Link
    bar.appendChild(activeBtn('&#128279;', 'Add / edit link', () => editor.isActive('link'), () => {
        const previous = editor.getAttributes('link').href || '';
        const url = window.prompt('Link URL (leave empty to remove):', previous);
        if (url === null) return;
        if (url === '') {
            editor.chain().focus().unsetLink().run();
        } else {
            editor.chain().focus().setLink({ href: url, target: '_blank' }).run();
        }
    }));

    // Text colour
    const colorWrap = document.createElement('label');
    colorWrap.className = 'flex items-center gap-1 px-1 cursor-pointer';
    colorWrap.title = 'Text colour';
    colorWrap.innerHTML = '<span class="text-sm text-gray-700 font-bold">A</span>';
    const colorInput = document.createElement('input');
    colorInput.type = 'color';
    colorInput.value = '#1f2937';
    colorInput.className = 'w-6 h-6 p-0 border-0 bg-transparent cursor-pointer';
    colorInput.addEventListener('input', () => {
        editor.chain().focus().setColor(colorInput.value).run();
    });
    colorWrap.appendChild(colorInput);
    bar.appendChild(colorWrap);

    // Highlight
    bar.appendChild(activeBtn('&#9634;', 'Highlight', () => editor.isActive('highlight'), () => editor.chain().focus().toggleHighlight({ color: '#fef08a' }).run()));
    bar.appendChild(sep());

    // Image upload
    const imageInput = document.createElement('input');
    imageInput.type = 'file';
    imageInput.accept = 'image/*';
    imageInput.className = 'hidden';
    const imgBtn = btn('&#128444;', 'Insert image', () => imageInput.click());
    bar.appendChild(imgBtn);

    imageInput.addEventListener('change', () => {
        const file = imageInput.files && imageInput.files[0];
        if (!file) return;
        imgBtn.disabled = true;
        imgBtn.innerHTML = '&#8987;';
        uploadImage(file)
            .then((url) => {
                editor.chain().focus().setImage({ src: url }).run();
            })
            .catch((err) => {
                if (typeof window.showNotification === 'function') {
                    window.showNotification(err.message || 'Image upload failed', 'error');
                } else {
                    window.alert(err.message || 'Image upload failed');
                }
            })
            .finally(() => {
                imgBtn.disabled = false;
                imgBtn.innerHTML = '&#128444;';
                imageInput.value = '';
            });
    });
    bar.appendChild(imageInput);

    // Image layout controls (visible when an image is selected)
    const imgControls = document.createElement('div');
    imgControls.className = 'pb-img-controls hidden items-center gap-1 ml-1 pl-2 border-l border-gray-300';

    const sizeSelect = document.createElement('select');
    sizeSelect.className = 'text-xs border rounded px-1 py-1 bg-white';
    sizeSelect.title = 'Image width';
    [['', 'Size: auto'], ['25%', 'Width 25%'], ['50%', 'Width 50%'], ['75%', 'Width 75%'], ['100%', 'Width 100%']].forEach(([value, label]) => {
        const opt = document.createElement('option');
        opt.value = value;
        opt.textContent = label;
        sizeSelect.appendChild(opt);
    });
    sizeSelect.addEventListener('change', () => applyImageAttrs({ width: sizeSelect.value }));

    const floatSelect = document.createElement('select');
    floatSelect.className = 'text-xs border rounded px-1 py-1 bg-white';
    floatSelect.title = 'Text wrapping around image';
    [['', 'No wrap'], ['left', 'Image left, text wraps right'], ['right', 'Image right, text wraps left']].forEach(([value, label]) => {
        const opt = document.createElement('option');
        opt.value = value;
        opt.textContent = label;
        floatSelect.appendChild(opt);
    });
    floatSelect.addEventListener('change', () => applyImageAttrs({ float: floatSelect.value }));

    imgControls.appendChild(sizeSelect);
    imgControls.appendChild(floatSelect);
    bar.appendChild(imgControls);

    function applyImageAttrs(attrs) {
        const { state, view } = editor;
        const { from, to } = state.selection;
        let updated = false;

        state.doc.nodesBetween(from, to, (node, pos) => {
            if (node.type.name === 'image') {
                view.dispatch(state.tr.setNodeMarkup(pos, undefined, { ...node.attrs, ...attrs }));
                updated = true;
                return false;
            }
        });

        if (!updated && typeof window.showNotification === 'function') {
            window.showNotification('Click an image in the text first', 'error');
        }
    }

    /** Sync active button states + image controls */
    function syncToolbar() {
        bar.querySelectorAll('.pb-btn').forEach((b) => {
            if (typeof b._isActive !== 'function') return;
            const active = b._isActive();
            b.className =
                'pb-btn px-2 py-1 text-sm rounded border transition-colors ' +
                (active
                    ? 'bg-blue-100 border-blue-300 text-blue-800'
                    : 'border-transparent text-gray-700 hover:bg-white hover:border-gray-300');
        });

        const hasImage = editor.isActive('image');
        imgControls.className =
            'pb-img-controls ' + (hasImage ? 'flex' : 'hidden') +
            ' items-center gap-1 ml-1 pl-2 border-l border-gray-300';
        if (hasImage) {
            const attrs = editor.getAttributes('image');
            sizeSelect.value = attrs.width || '';
            floatSelect.value = attrs.float || '';
        }
    }

    editor.on('selectionUpdate', syncToolbar);
    editor.on('transaction', syncToolbar);
    syncToolbar();

    return bar;
}

/**
 * Create a TipTap editor inside the given element.
 *
 * options:
 *   - html: initial HTML content
 *   - placeholder: placeholder text
 *   - minHeight / maxHeight for the editable area
 *   - onUpdate(html): callback fired on every change
 */
export function create(target, options = {}) {
    const el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) return null;
    destroy(el);

    const wrapper = document.createElement('div');
    wrapper.className = 'pb-editor border border-gray-300 rounded-lg overflow-hidden bg-white';

    const editable = document.createElement('div');
    editable.className = 'pb-editor-content px-3 py-2 bg-white';
    editable.style.minHeight = options.minHeight || '180px';
    editable.style.maxHeight = options.maxHeight || '420px';
    editable.style.overflowY = 'auto';

    wrapper.appendChild(editable);
    el.appendChild(wrapper);

    const editor = new Editor({
        element: editable,
        extensions: [
            StarterKit.configure({ heading: { levels: [1, 2, 3] } }),
            Underline,
            Link.configure({ openOnClick: false, autolink: true }),
            QuillCompatibleTextAlign.configure({ types: ['heading', 'paragraph'] }),
            TextStyle,
            Color,
            Highlight.configure({ multicolor: true }),
            Placeholder.configure({
                placeholder: options.placeholder || 'Start typing your content...',
            }),
            ResizableImage,
        ],
        content: options.html || '',
        onUpdate: ({ editor: ed }) => {
            el.dataset.html = ed.getHTML();
            if (typeof options.onUpdate === 'function') options.onUpdate(ed.getHTML());
        },
    });

    const toolbar = buildToolbar(editor);
    wrapper.insertBefore(toolbar, editable);

    el.dataset.html = editor.getHTML();
    instances.set(el, editor);
    tracked.add(el);
    return editor;
}

export function destroy(target) {
    const el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) return;
    const editor = instances.get(el);
    if (editor) {
        editor.destroy();
        instances.delete(el);
    }
    tracked.delete(el);
    el.innerHTML = '';
    delete el.dataset.html;
}

/**
 * Tear down every mounted editor (used when the block editor sidebar closes).
 */
export function destroyAll() {
    Array.from(tracked).forEach((el) => destroy(el));
    tracked.clear();
}

export function getHtml(target) {
    const el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) return '';
    const editor = instances.get(el);
    return editor ? editor.getHTML() : el.dataset.html || '';
}

export function setHtml(target, html) {
    const el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) return;
    const editor = instances.get(el);
    if (editor) editor.commands.setContent(html || '', false);
    el.dataset.html = html || '';
}

window.PageBuilderEditor = { create, destroy, destroyAll, getHtml, setHtml, uploadImage };



