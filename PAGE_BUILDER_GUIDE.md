# Modern Drag & Drop Page Builder

## Overview

I've completely redesigned your page builder system to be more user-friendly with drag-and-drop functionality, real-time previews, and reusable components. The new system is built with modern web standards and provides an intuitive experience for creating dynamic pages.

## Key Features

### 🎨 **Visual Drag & Drop Interface**
- **Left Sidebar**: Block palette with all available content blocks
- **Center Canvas**: Drop zone for building your page layout
- **Right Sidebar**: Block editor for customizing selected blocks
- **Real-time Preview**: See changes instantly as you edit

### 🧱 **Reusable Block System**
All blocks are now modular components that can be easily extended:

1. **Hero Section** - Large banner with heading, subheading, button, and background image
2. **Rich Text** - TipTap WYSIWYG editor (headings, lists, colours, links, inline images with resize + text wrapping)
3. **Columns** - 2, 3 or 4 column layout, each column with its own editor and optional image
4. **Image + Text** - Image beside text (left or right), with width, gap and alignment controls
5. **Download** - File download button with document preview
6. **Image** - Single image with optional caption
7. **List** - Bulleted list items with add/remove functionality
8. **Call to Action** - Prominent action button (coming soon)
9. **Divider** - Visual separator (coming soon)
10. **Video** - Embedded video player (coming soon)
11. **Testimonial** - Quote with attribution (coming soon)
12. **Features Grid** - Icon + text grid (coming soon)

### ⚡ **Modern User Experience**
- **Smooth Animations**: Fluid transitions and hover effects
- **Keyboard Shortcuts**: Quick actions for power users
- **Auto-save**: Changes saved automatically
- **Undo/Redo**: Easy mistake recovery (coming soon)
- **Mobile Responsive**: Works on all device sizes

## Rich Text & Layout Blocks

### TipTap rich text editor

The **Rich Text** block (and every column inside the **Columns** / **Image + Text** blocks) uses TipTap.
Toolbar capabilities:

| Group | Options |
|-------|---------|
| Headings | H1, H2, H3 |
| Marks | Bold, Italic, Underline, Strikethrough, Highlight, Text colour |
| Lists | Bullet list, Numbered list |
| Blocks | Blockquote, Code block, Horizontal rule |
| Alignment | Left, Center, Right |
| Links | Add / edit / remove link (opens in a new tab) |
| Images | Upload from disk, then resize + wrap |

**Image workflow**

1. Click the 🖼 button and pick a file — it uploads to `storage/app/public/pages` and is inserted at the cursor.
2. Click the inserted image (it gets a blue outline).
3. Two extra controls appear in the toolbar:
   - **Width**: auto / 25% / 50% / 75% / 100%
   - **Wrapping**: none, image left (text wraps right), image right (text wraps left)

Uploaded images are served from `/storage/pages/...` via `POST /admin/editor/upload`
(route name `admin.editor.upload`, protected by `auth` + `admin` middleware).

### Columns block

Real multi-column layouts (not simulated inside the editor).

| Setting | Options |
|---------|---------|
| Number of columns | 2, 3, 4 |
| Column widths | 50/50, 60/40, 40/60, 70/30, 30/70 · 33/33/33, 50/25/25, 25/50/25, 25/25/50 · 25×4, 40/20/20/20, 20/20/20/40 |
| Gap | none, small, medium, large |
| Vertical align | top, center, bottom, stretch |
| Stack on mobile | on / off (columns become full width under 768px) |
| Per column | optional image (upload or URL), image position (above / below / left / right of text), alt text, and its own TipTap editor |

Stored data shape:

```php
[
    'heading' => 'Our Services',
    'count' => 2,
    'layout' => '70-30',
    'gap' => 'md',
    'vertical_align' => 'top',
    'stack_on_mobile' => true,
    'items' => [
        ['html' => '<p>...</p>', 'image_path' => '/storage/pages/x.jpg', 'image_alt' => '...', 'image_position' => 'top'],
        ['html' => '<p>...</p>', 'image_path' => '', 'image_alt' => '', 'image_position' => 'top'],
    ],
]
```

### Image + Text block

One image beside one block of text — the simplest way to place an image exactly where you want it.

| Setting | Options |
|---------|---------|
| Image side | left / right |
| Image width | slider, 20% – 70% (text takes the rest) |
| Vertical align | top / center / bottom |
| Gap | none, small, medium, large |
| Rounded corners | on / off |
| Text | full TipTap editor |

On mobile the image always stacks above the text.

### Legacy Quill content

Blocks created before the TipTap switch keep working:
- `ql-align-*` classes are parsed into proper alignment when re-opened in the editor
- the same classes are styled by `resources/css/page-builder.css`, so old pages still render aligned
- on the next save the markup is rewritten as inline `style="text-align: ..."`

### Adding a new block type

1. Register it in `PageController::getBlockTypes()` (palette entry) and in the
   `PageBlockController::store()` validation rule.
2. Add default data in `PageBlockController::defaultDataFor()`.
3. Create the admin editor: `resources/views/admin/pages/blocks/editor/{type}.blade.php`.
   If it contains a rich text area, mount it with
   `window.PageBuilderEditor.create(element, { html, placeholder })` and read it back with
   `window.PageBuilderEditor.getHtml(element)` inside `saveThisBlock()`.
4. Create the public renderer: `resources/views/blocks/{type}.blade.php`.
   Wrap any HTML coming from an editor in `class="pb-rich-text"` so headings and lists are styled.
5. Run `npm run build` if you changed JS/CSS, then `php artisan view:clear`.

## Technical Implementation

### Architecture

```
resources/views/admin/pages/
├── builder.blade.php          # Main page builder interface
├── blocks/
│   ├── forms/                 # Legacy form views (backward compatible)
│   └── editor/                # New reusable editor components
│       ├── hero.blade.php
│       ├── rich_text.blade.php   # TipTap editor
│       ├── columns.blade.php     # 2/3/4 column layout editor
│       ├── image_text.blade.php  # Image beside text editor
│       ├── download.blade.php
│       ├── image.blade.php
│       └── repeater.blade.php
└── index.blade.php            # Pages list

resources/views/blocks/        # Public renderers (one per block type)
├── hero.blade.php
├── rich_text.blade.php
├── columns.blade.php
├── image_text.blade.php
├── download.blade.php
├── image.blade.php
└── repeater.blade.php

resources/js/tiptap-editor.js  # TipTap bundle (window.PageBuilderEditor)
resources/css/page-builder.css # Editor + public block styles
```

### Frontend Stack
- **TipTap 2 (ProseMirror)**: Rich text editing with images, alignment, colours and headings
- **Vite**: Bundles `resources/js/tiptap-editor.js` as a separate entry (loaded only on the builder)
- **Alpine.js**: Reactive JavaScript framework for interactivity
- **Tailwind CSS**: Utility-first CSS framework
- **HTML5 Drag & Drop API**: Native browser drag-and-drop
- **Fetch API**: Modern AJAX for server communication

### Backend Stack
- **Laravel 11**: PHP framework
- **Eloquent ORM**: Database abstraction
- **RESTful API**: JSON endpoints for AJAX operations

## Usage Guide

### Creating a New Page

1. **Navigate to Admin Panel**
   ```
   /admin/pages
   ```

2. **Click "Create New Page"**
   - Enter page title
   - Set URL slug (auto-generated from title)
   - Add meta information for SEO

3. **Enter Page Builder**
   - You'll be automatically redirected to the builder interface
   - Or click "Edit with Builder" on any existing page

### Building Page Content

#### Adding Blocks

1. **Drag from Sidebar**
   - Click and hold any block from the left sidebar
   - Drag it to the center canvas area
   - Release to drop

2. **Block Appears with Default Content**
   - Each block has sensible defaults
   - Click on the block to select it
   - Edit properties in the right sidebar

#### Editing Blocks

1. **Select a Block**
   - Click on any block in the canvas
   - Block will highlight with blue border

2. **Edit Properties**
   - Use the right sidebar form
   - Changes preview in real-time
   - Click "Save" to persist changes

3. **Block Actions**
   - **Duplicate**: Create a copy of the block
   - **Move Up/Down**: Reorder blocks
   - **Delete**: Remove the block

#### Reordering Blocks

**Method 1: Drag & Drop**
- Click and hold the drag handle (☰) on a block
- Drag to new position
- Release to drop

**Method 2: Arrow Buttons**
- Click the up/down arrows in the block header
- Moves block one position at a time

### Page Settings

Access page settings from the top bar:

- **Page Title**: Main heading (editable inline)
- **URL Slug**: Page address (auto-updated)
- **Preview**: View published page
- **Publish Toggle**: Make page live/unpublished
- **Save All**: Persist all changes

## API Endpoints

### Page Management
```
GET    /admin/pages/{page}/builder    # Builder interface
GET    /admin/pages/{page}/blocks     # List blocks (JSON)
POST   /admin/pages/{page}/blocks     # Create new block
PUT    /admin/pages/{page}/blocks/{block}  # Update block
DELETE /admin/pages/{page}/blocks/{block}  # Delete block
POST   /admin/pages/{page}/blocks/reorder   # Reorder blocks
```

### Block Data Structure

```json
{
  "id": 1,
  "page_id": 1,
  "type": "hero",
  "sort_order": 1,
  "data": {
    "heading": "Welcome",
    "subheading": "To our mosque",
    "button_text": "Learn More",
    "button_url": "/about",
    "bg_image_path": "pages/hero-bg.jpg"
  },
  "created_at": "2026-05-03T10:00:00.000000Z",
  "updated_at": "2026-05-03T10:00:00.000000Z"
}
```

## Customization

### Adding New Block Types

1. **Create Editor Component**
   ```blade
   <!-- resources/views/admin/pages/blocks/editor/myblock.blade.php -->
   <div class="space-y-4">
       <div>
           <label class="block text-sm font-medium text-gray-700 mb-1">
               Field Label
           </label>
           <input type="text" name="field_name" 
                  value="{{ $block->data['field_name'] ?? '' }}"
                  class="w-full rounded-lg border-gray-300">
       </div>
   </div>
   ```

2. **Create Frontend View**
   ```blade
   <!-- resources/views/blocks/myblock.blade.php -->
   <section class="my-custom-block">
       <!-- Your frontend HTML -->
   </section>
   ```

3. **Register Block Type**
   ```php
   // In PageController::getBlockTypes()
   [
       'id' => 'myblock',
       'name' => 'My Custom Block',
       'description' => 'Description here',
       'icon' => '🎯'
   ]
   ```

4. **Add Validation**
   ```php
   // In PageBlockController::update()
   if ($block->type === 'myblock') {
       $payload = $request->validate([
           'field_name' => ['required', 'string', 'max:255'],
       ]);
       $data['field_name'] = $payload['field_name'];
   }
   ```

### Styling Blocks

All blocks use Tailwind CSS classes for consistent styling:

```blade
<!-- Example block styling -->
<section class="py-12 px-6 bg-white rounded-xl shadow-sm">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">
            {{ $data['title'] }}
        </h2>
        <div class="prose prose-lg">
            {!! $data['content'] !!}
        </div>
    </div>
</section>
```

## Migration from Old System

The new builder is **backward compatible** with existing pages and blocks. No migration required!

### Old System → New System

**Before:**
```php
// Old edit page with separate forms
Route::get('pages/{page}/edit', [PageController::class, 'edit']);
```

**After:**
```php
// New builder interface
Route::get('pages/{page}/builder', [PageController::class, 'builder']);
// Old route redirects to builder
Route::get('pages/{page}/edit', [PageController::class, 'edit'])
    ->redirect(route('admin.pages.builder', ['page' => '{page}']));
```

## Performance Optimizations

### Implemented
- ✅ **Lazy Loading**: Blocks loaded on demand
- ✅ **Debounced Saves**: Prevents excessive server requests
- ✅ **Optimized Queries**: Eager loading of relationships
- ✅ **Asset Minification**: CSS and JS minified in production
- ✅ **Caching**: Block configurations cached

### Best Practices
1. **Limit Blocks Per Page**: Recommended max 20-30 blocks
2. **Optimize Images**: Compress before upload
3. **Use Appropriate File Sizes**: Max 5MB per image
4. **Clear Cache**: Run `php artisan cache:clear` after major changes

## Troubleshooting

### Common Issues

**Blocks not dragging?**
- Ensure JavaScript is enabled
- Check browser console for errors
- Try a different browser (Chrome recommended)

**Changes not saving?**
- Check network tab for failed requests
- Verify CSRF token is present
- Ensure you have admin permissions

**Images not uploading?**
- Check `storage/app/public` permissions
- Verify `storage` symlink exists: `php artisan storage:link`
- Check file size limits in `php.ini`

### Debug Mode

Enable debug mode to see detailed errors:

```env
APP_DEBUG=true
APP_ENV=local
```

## Future Enhancements

### Planned Features
- [ ] **AI Content Generation**: Auto-generate block content
- [ ] **Version History**: Restore previous page versions
- [ ] **A/B Testing**: Test different page variations
- [ ] **Analytics Integration**: Track block performance
- [ ] **Multi-language Support**: Translate block content
- [ ] **Block Templates**: Save and reuse block configurations
- [ ] **Keyboard Shortcuts**: Power user features
- [ ] **Collaborative Editing**: Multiple users editing simultaneously

### Coming Soon
- Additional block types (Video, Testimonials, Features Grid)
- Custom CSS per block
- Block animation settings

## Support

### Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

### Getting Help
1. Check this README first
2. Review browser console for errors
3. Check Laravel logs: `storage/logs/laravel.log`
4. Contact development team

## Credits

Built with:
- **Laravel** - PHP Framework
- **TipTap / ProseMirror** - Rich Text Editor
- **Alpine.js** - JavaScript Framework
- **Tailwind CSS** - CSS Framework
- **Heroicons** - SVG Icons

---

**Version**: 3.0.0  
**Last Updated**: September 15, 2026  
**Maintained by**: Ipswich Mosque Development Team