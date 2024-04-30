<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown Editor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://kit.fontawesome.com/251b4c65ed.js" crossorigin="anonymous"></script>
    <style>
        #editor, #preview {
            height: 90vh;
        }
        #preview {
            overflow-y: auto;
        }

        img {
            max-width: 100%;
            padding:10px;
            border: 1px solid #ddd;
        }

        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-left: 3px solid #ccc;
            margin: 10px 0;
            overflow: auto;
        }
        
        /* Sliglt smaller headings */
        h1 {
            font-size: 2em;
        }
        h2 {
            font-size: 1.5em;
        }
        h3 {
            font-size: 1.17em;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            
            <a class="navbar-brand" href="#"><i class="far fa-sticky-note"></i> Markdown Editor</a>

            <!-- add save button float right -->
            <button class="btn btn-warning" onclick="saveFile()"><i class="far fa-save"></i> Save to browser</button>
        </div>
    </nav>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-6">
                <textarea id="editor" class="form-control" oninput="updatePreview()"></textarea>
            </div>
            <div class="col-md-6">
                <div id="preview" class="p-3 border bg-light"></div>
            </div>
        </div>
    </div>

    <script>
        var auto_save_timeout = null;

        // load file from local storage
        const markdownText = localStorage.getItem('markdownText');
        if (markdownText) {
            document.getElementById('editor').value = markdownText;
        }

        function updatePreview() {
            const markdownText = document.getElementById('editor').value;
            document.getElementById('preview').innerHTML = marked.parse(markdownText);
            buttonSave();

            // auto save if not changed for more than 10s
            if (auto_save_timeout) {
                clearTimeout(auto_save_timeout);
            }
            auto_save_timeout = setTimeout(() => {
                saveFile();
            }, 5000);
        }
        updatePreview();

        function saveFile() {
            const markdownText = document.getElementById('editor').value;
            localStorage.setItem('markdownText', markdownText);
            buttonSaved();
        }

        function buttonSave() {
            let btn = document.querySelector('.btn');
            btn.classList.remove('btn-secondary');
            btn.classList.add('btn-warning');
            btn.innerHTML = '<i class="far fa-save"></i> Save to browser';
        }

        function buttonSaved() {
            let btn = document.querySelector('.btn');
            btn.classList.remove('btn-warning');
            btn.classList.add('btn-secondary');
            btn.innerHTML = 'Saved';
        }

        // Catch Ctrl + S
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                saveFile();
            }
        });

    </script>
</body>
</html>
