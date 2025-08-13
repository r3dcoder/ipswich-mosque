<div class="header">

    <div class="prayer-times-section   ">
        <div class="prayer-left">
            <p class="date">13th August 2025 · 19 Safar 1447</p>
            <p class="juma">JUM'A 13:15 & 14:15 PRAYER TIMES</p>
        </div>

        <div class="prayer-right bg-amber-500">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Fajr</th>
                        <th>Zuhr</th>
                        <th>‘Asr</th>
                        <th>Maghrib</th>
                        <th>‘Ishā</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Begins</td>
                        <td>4:02</td>
                        <td>1:11</td>
                        <td>5:06</td>
                        <td>8:30</td>
                        <td>9:36</td>
                    </tr>
                    <tr>
                        <td>Jamā‘ah</td>
                        <td>4:22</td>
                        <td>1:30</td>
                        <td>6:30</td>
                        <td>8:37</td>
                        <td>10:00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <nav>
        <div class="logo">
            <img src="{{ asset("images/logo.png") }}" alt="logo" />
            <h1>Ipswich Mosque</h1>
        </div>
        <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Services</a>
            </li>
            <li>
                <a href="#">Blog</a>
            </li>
            <li>
                <a href="#">Contact Us</a>
            </li>
        </ul>
        <div class="hamburger">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </nav>
    <div class="menubar">
        <ul>
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">Services</a>
            </li>
            <li>
                <a href="#">Blog</a>
            </li>
            <li>
                <a href="#">Contact Us</a>
            </li>
        </ul>
    </div>
    </div>

<script>
    const mobileNav = document.querySelector(".hamburger");
    const navbar = document.querySelector(".menubar");

    const toggleNav = () => {
        navbar.classList.toggle("active");
        mobileNav.classList.toggle("hamburger-active");
    };
    mobileNav.addEventListener("click", () => toggleNav());

</script>