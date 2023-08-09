<!-- jquery-->
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="js/jquery.hotkeys.js"></script>

<!-- bootstrap-->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- builder code-->
<script src="libs/builder/builder.js"></script>
<!-- undo manager-->
<script src="libs/builder/undo.js"></script>
<!-- inputs-->
<script src="libs/builder/inputs.js"></script>
<!-- components-->
<script src="libs/builder/components-bootstrap5.js"></script>
<script src="libs/builder/components-widgets.js"></script>

<script>
    let pages = [
        {
            name:"narrow-jumbotron",
            title:"Jumbotron",
            url: "demo/narrow-jumbotron/index.html",
            file: "demo/narrow-jumbotron/index.html"
        },
        {name:"landing-page", title:"Landing page", url: "demo/landing/index.html", file: "demo/landing/index.html"},
    ];

    $(function() {

        let firstPage = Object.keys(pages)[0];
        Vvveb.Builder.init(pages[firstPage]["url"], function() {
            //load code after page is loaded here
        });

        Vvveb.Gui.init();
        Vvveb.FileManager.init();
        Vvveb.SectionList.init();
        Vvveb.Breadcrumb.init();

        Vvveb.FileManager.addPages(pages);
        Vvveb.FileManager.loadPage(pages[firstPage]["name"]);
        Vvveb.Breadcrumb.init();

        //if url has #no-right-panel set one panel demo
        if (window.location.hash.indexOf("no-right-panel") != -1) {
            Vvveb.Gui.toggleRightColumn();
        }
    });
    <script>