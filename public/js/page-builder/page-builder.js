import "grapesjs/dist/css/grapes.min.css";
import grapesjs from "grapesjs";
import preset from "grapesjs-preset-newsletter";
import flexbox from "grapesjs-blocks-flexbox";

const editor = grapesjs.init({
    container: "#gjs",
    plugins: [preset, flexbox],
    height: "100vh",
    pluginsOpts: {
        [preset]: {
            /* options */
        },
        [flexbox]: {
            /* options */
        },
    },
    panels: {},
    storageManager: false,

    // Add commands to export html
    commands: {
        defaults: [
            {
                // id and run are mandatory in this case
                id: "export-to-html",
                run() {
                    var html = editor.runCommand("gjs-get-inlined-html");
                    post({ contenueHTML: html });
                },
            },
        ],
    },

    // Change the url of image
    assetManager: {
        storageType: "",
        storeOnChange: true,
        storeAfterUpload: true,
        upload: `${window.location.origin}/images`, //for temporary storage
        assets: [],
        uploadFile: function (e) {
            var files = e.dataTransfer ? e.dataTransfer.files : e.target.files;
            var formData = new FormData();
            for (var i in files) {
                formData.append("file-" + i, files[i]); //containing all the selected images from local
            }

            $.ajax({
                url: "/dashboard/configuration/upload_image",
                type: "POST",
                data: formData,
                contentType: false,
                crossDomain: true,
                dataType: "json",
                mimeType: "multipart/form-data",
                processData: false,
                headers: {
                    "X-CSRF-Token": $('meta[name="_token"]').attr("content"),
                },

                success: function (result) {
                    console.log("----- Success -----");
                    console.log(result);
                    var myJSON = [];
                    $.each(result["data"], function (key, value) {
                        myJSON[key] = value;
                    });
                    var images = myJSON;
                    editor.AssetManager.add(images); //adding images to asset  manager of GrapesJS
                },

                error: function (xhr, ajaxOptions, thrownError) {
                    console.log("----- Error -----");
                    console.log(xhr.responseText); //Ce code affichera le message d'erreur, ici Message d'erreur.
                },
            });
        },
    },
});

if (contenueHTML) {
    editor.setComponents(contenueHTML);
}

const panelManager = editor.Panels;

// Remove buttons from panels unused
panelManager.removeButton("options", "c65");
panelManager.removeButton("options", "c66");
panelManager.removeButton("options", "c67");
panelManager.removeButton("options", "c68");

// Create panels to save changes
editor.Panels.addPanel({
    id: "save-changes",
    el: ".panel__save-changes",
    buttons: [
        {
            id: "export",
            className: "save-changes-button",
            label: "Enregistrer",
            command: "export-to-html",
        },
    ],
});

/**
 * Sends a request to the specified url from a form.
 */
function post(params) {
    // The rest of this code assumes you are not using a library.
    // It can be made less verbose if you use one.
    const form = document.getElementById("panel__save-changes");

    for (const key in params) {
        if (params.hasOwnProperty(key)) {
            const hiddenField = document.createElement("input");
            hiddenField.type = "hidden";
            hiddenField.name = key;
            hiddenField.value = params[key];

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}

const styleManager = editor.StyleManager;

console.log(editor.getSelected());
