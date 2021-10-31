function fetchlinks (e) {
    var value = document.getElementById("inputURL").value;
    console.log(value);
    var isVimeo = checkVimeo(value);
    console.log(isVimeo)
    if (isVimeo) {
        isVimeo = isVimeo[isVimeo.length - 1];
        getVimeoDetails(isVimeo);
        return 0;
    }
    var result = (extractValue(value));
    if (result === 0) {
        return 0;
    }
    appendImages(result);
    return false;
}
function initFunction () {
    documentReady();

    document.getElementById("submitButton").onclick = function (e) {
        fetchlinks(e);
    }
}
function setDisplay (value) {
    var arrayOfElements = document.getElementsByClassName('download-bt');
    var lengthOfArray = arrayOfElements.length;

    for (var i = 0; i < lengthOfArray; i++) {
        arrayOfElements[i].style.display = value;
    }
}

    function appendVimeoVideos (hdLink, mdLink, sdLink) {
        setDisplay("none");

        document.getElementById("downlist").style.display = "block";
        document.getElementById("upperlist").style.display = "block";
        var element = document.getElementById("maxres")
        element.setAttribute("src", hdLink);
        element.style.display = "block";
        element.setAttribute("src", sdLink);
        element.style.display = "block";
        element.setAttribute("src", mdLink);
        document.getElementById("extraYTImg").style.display = "none";
        document.getElementById("highlink").style.display = "none";
    }

    function checkVimeo (data) {
        var res = data.match(/https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/)
        return res;
    }

    function getVimeoDetails (link) {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
                if (xmlhttp.status == 200) {
                    var data = (JSON.parse(xmlhttp.responseText));
                    appendVimeoVideos(data[0].thumbnail_large, data[0].thumbnail_medium, data[0].thumbnail_small);
                }
                else if (xmlhttp.status == 400) {
                    alert("There is no video in the vimeo link you have given");
                }
                else {
                    alert("There is no video in the vimeo link you have given");
                }
            }
        };

        xmlhttp.open("GET", 'https://vimeo.com/api/v2/video/' + link + '.json', true);
        xmlhttp.send();

    }
    function isMaxResAvailable (result) {
        var img = new Image()
        img.onload = function () {
            if (this.width < 1280) {

                document.getElementById("highlink").style.display = "none";
                document.getElementById("hdrestext").textContent = "High resolution not available";
                isSDAvailalbe(result);
            }
        }
        img.onerror = function () {
            document.getElementById("sdrestext").textContent = "High resolution not available";
            isSDAvailalbe(result);
        }
        img.src = "https://img.youtube.com/vi/" + result + "/maxresdefault.jpg";

    }
    function isImageAvailable () {

        alert("Please check the youtube video link. It appears the video link is broken.")


    }
   

    function appendImages (result) {
        //document.getElementsByClassName("download-btn").style.display = "block";
        setDisplay("block");

        document.getElementById("highlink").style.display = "inline";
        document.getElementById("inputURL").value = "https://youtube.com/watch?v=" + result;
        document.getElementById("downlist").style.display = "block";
        document.getElementById("upperlist").style.display = "block";
        document.getElementById("lowlink").setAttribute("href", "https://img.youtube.com/vi/" + result + "/mqdefault.jpg");

	document.getElementById("highlink").href = "https://img.youtube.com/vi/" + result + "/maxresdefault.jpg";
        document.getElementById("hqreslink").href = "https://i3.ytimg.com/vi/" + result + "/hqdefault.jpg";
        document.getElementById("lowlink").href = "https://img.youtube.com/vi/" + result + "/mqdefault.jpg";
        isMaxResAvailable(result);

        document.getElementById("extraYTImg").style.display = "block";
    }

    function extractValue (data) {
        console.log(data)
        var res = data.match(/(?:https?:\/{2})?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)(?:\/watch\?v=|\/)([^\s&]+)/)
        if (res == undefined) {
            alert("Please check the URL you have entered");
            return 0;
        }
        return res[1];
    }


    function showAlertInfo (info) {
        var div = document.createElement("div");
        div.setAttribute("class", "alert alert-info alert-dismissable fade in " + info);
        div.setAttribute("id", "alertBanner");
        var aTag = document.createElement("a");
        a.setAttribute(href, "#");
        a.setAttribute("class", "close");
        a.setAttribute("aria-label", "close");
        a.setAttribute("text", "x");
        a.setAttribute("data-dismiss", "alert");
        div.appendChild(a);
        div.appendChild(html);
        document.getElementById("images").appendChild(div);
    }
    function documentReady () {

        (function () {
            function getQueryStringValue (key) {
                return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
            }
            var id = getQueryStringValue('id');
            var type = getQueryStringValue("type");
            if (type == "vimeo") {
                document.getElementById("inputURL").value = "https://vimeo.com/" + id
                var vimId = checkVimeo("https://www.vimeo.com/" + id);
                vimId = vimId[vimId.length - 1];

                getVimeoDetails(vimId);
                return 0;
            }
            if (id !== "") {
                appendImages(id);
            }

        }());
    };
    initFunction();
