<style>
    :root {
        --sans: -apple-system, blinkmacsystemfont, "Segoe UI", roboto, oxygen, ubuntu, cantarell, "Open Sans", "Helvetica Neue", sans-serif;
    }
    :root[color-mode="dark"] {
        --surface: #191a20;
        --primary-text: #fff;
        --secondary-text: #a5a9ed;
        --link-text: #a5a9ed;
    }
    :root[color-mode="light"] {
        --surface: #f5f5f5;
        --primary-text: #212121;
        --secondary-text: #1976d2;
        --link-text: #212121;
    }
    *, *:before, *:after {
        box-sizing: border-box;
    }
    body, html {
        margin: 0;
        height: 100%;
        font-size: 1.2rem;
        line-height: 1.4rem;
        font-family: var(--sans);
        background-color: #191a20;
        background-color: var(--surface, #191a20);
        color: #fff;
        color: var(--primary-text, #fff);
    }
    p, blockquote, li {
        text-align: justify;
        line-height: 1.6rem;
    }
    blockquote {
        position: relative;
        padding: 2rem 0;
        width: 100%;
        margin: 40px auto;
        border-top: solid 3px;
        border-bottom: solid 3px;
        font-size: 1.2rem;
        font-style: italic;
        line-height: 1.8rem;
        border-color: #a5a9ed;
        border-color: var(--secondary-text, #a5a9ed);
    }
    blockquote:after {
        position: absolute;
        content: "”";
        color: #a5a9ed;
        color: var(--secondary-text, #a5a9ed);
        font-size: 8rem;
        bottom: -40px;
        right: 10px;
    }
    a, a:link, a:visited {
        color: #a5a9ed;
        color: var(--link-text, #a5a9ed);
    }
    .wrapper {
        margin: 0 auto;
        padding: 3rem;
        display: grid;
        justify-content: start;
        align-content: start;
        gap: 0 5px;
        grid-template-areas: "widgets" "header" "content" "sidebar" "footer";
    }
    .wrapper .main-head {
        grid-area: header;
        font-size: 1.2rem;
        padding: 1rem 0 5rem;

        color: #a5a9ed;
        color: var(--secondary-text, #a5a9ed);
    }
    .wrapper .main-head h1 {
        border-bottom: 3px solid;
        border-color: #a5a9ed;
        border-color: var(--secondary-text, #a5a9ed);
        line-height: 3.5rem;
        padding-bottom: 1rem;
    }
    .wrapper .head-widgets {
        grid-area: widgets;
        padding: 1rem 0;
    }
    .wrapper .content {
        grid-area: content;
        padding-bottom: 2rem;
    }
    .wrapper .side {
        grid-area: sidebar;
    }
    .wrapper .side p {
        text-align: left;
    }
    .wrapper .main-footer {
        grid-area: footer;
        padding: 2rem 0;
        text-align: center;
        border-top: 1px solid;
        border-color: #fff;
        border-color: var(--primary-text, #fff);
        font-size: 0.9rem;
    }
    @media (min-width: 3000px) {
        .wrapper {
            max-width: 1500px;
            grid-template-columns: 8fr 4fr;
            grid-template-areas: "header widgets" "content sidebar" "footer footer";
        }
    }

</style>
<div class="wrapper">
    <header class="main-head">
        <h1><?php echo $message ?></h1>
        <p>Tệp: <b><?php echo $file ?></b></p>
        <p>Dòng: <b><?php echo $line ?></b></p>
    </header>

    <?php if (! empty($errors)) { ?>
        <article class="content">
            <h2>Dấu vết</h2>
            <blockquote>
                <?php foreach ($errors as $error) { ?>
                <h3>--> <?php echo $error['file'] ?></h3>
                <ul>
                    <li>Hàm: <b><?php echo $error['function'] ?></b></li>
                    <li>Dòng: <b><?php echo $error['line'] ?></b></li>
                    <li>Lớp: <b><?php echo $error['class'] ?></b></li>
                </ul>
                    <br>
                <?php } ?>
            </blockquote>
        </article>
    <?php } ?>

    <footer class="main-footer">
        <p style="text-align:center">Made with love by <a href="https://maoleng.dev" target="blank">Mao Leng</a>.</p>
        <p style="text-align:center">Thank you for visiting!</p>
    </footer>
</div>
<script>
    // If CSS Custom Properties or Variables are supported
    if (window.CSS && CSS.supports("color", "var(--primary)")) {
        const radios = document.querySelectorAll('input[type="radio"]');

        const toggleColorMode = function toggleColorMode(e) {
            //console.log(e.currentTarget.value);
            // Switch to Light Mode
            if (e.currentTarget.value === "on") {
                // Sets the custom html attribute
                document.documentElement.setAttribute("color-mode", "dark");
                // Sets the user's preference in local storage
                localStorage.setItem("color-mode", "dark");
                return;
            }
            /* Switch to Light Mode */
            document.documentElement.setAttribute("color-mode", "light");
            localStorage.setItem("color-mode", "light");
        };

        radios.forEach(function (radio) {
            radio.addEventListener("click", toggleColorMode);
        });
    } else {
        //hide the switcher
        const switcherContainer = document.querySelectorAll(".head-widgets")[0];
        switcherContainer.style.display = "none";
    }

</script>