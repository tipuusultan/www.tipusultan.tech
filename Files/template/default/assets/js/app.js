$(document).ready(function () {
    /**
     *
     * @param str str
     * @returns {boolean}
     */
    function isValidURL(str) {
        let elm;
        if (!elm) {
            elm = document.createElement('input');
            elm.setAttribute('type', 'url');
        }
        elm.value = str;
        return elm.validity.valid;
    }

    /**
     *
     * @param num
     * @param digits
     * @returns {string}
     */
    function formatNumber(num, digits = 1) {
        var si = [
            {value: 1, symbol: ""},
            {value: 1E3, symbol: "K"},
            {value: 1E6, symbol: "M"},
            {value: 1E9, symbol: "G"},
            {value: 1E12, symbol: "T"},
            {value: 1E15, symbol: "P"},
            {value: 1E18, symbol: "E"}
        ];
        var rx = /\.0+$|(\.[0-9]*[1-9])0+$/;
        var i;
        for (i = si.length - 1; i > 0; i--) {
            if (num >= si[i].value) {
                break;
            }
        }
        return (num / si[i].value).toFixed(digits).replace(rx, "$1") + si[i].symbol;
    }

    /**
     *
     * @param url
     * @param parameter
     * @returns {string|*}
     */
    function removeURLParameters(url) {
        url = new URL(url);
        url.search = "";
        return url.toString();
    }

    function getInstagramData() {
        showResult();
        /*
        var url = $('#input').val();
        var action = $('#action').val();
        var params = "/?__a=1";
        var result = "";
        var requestOptions = {
            method: 'GET',
            headers: new Headers(),
            redirect: 'follow'
        };
        if (isValidURL(url) === false) {
            url = 'https://www.instagram.com/' + url;
        } else {
            url = removeURLParameters(url);
        }
        if (action === "igtvVideos") {
            url = url + "/channel";
        }
        if (url.endsWith("/")) {
            params = "?__a=1";
        }
        fetch(url + params, requestOptions)
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                var jsonStr = JSON.stringify(data);
                $('#json').val(jsonStr);
                showResult();
            })
            .catch((error) => {
                console.log('error', error);
                showResult();
            });
         */
    }

    $('#input').on("change paste keyup keydown", function () {
        var url = $('#input').val();
        $('#input-source-link').val("view-source:" + url);
    });

    $('#copy').click(function (e) {
        var copyText = document.getElementById("input-source-link");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        $('#copy').text("Copied");
        e.preventDefault();
    });

    $('#paste').click(function (e) {
        var input = document.getElementById("input-page-source");
        navigator.clipboard.readText().then(clipText =>
            input.value = clipText);
        e.preventDefault();
    });

    $('#btnDownloadPost').click(function (e) {
        getInstagramData();
        e.preventDefault();
    });

    $('#btnDownloadStory').click(function (e) {
        getInstagramData();
        e.preventDefault();
    });

    $('#btnDownloadProfilePhoto').click(function (e) {
        getInstagramData();
        e.preventDefault();
    });

    $('#btnDownloadPrivatePost').click(function (e) {
        var pageSource = $('#input-page-source').val();
        var jsonStr = JSON.stringify({"source": pageSource});
        $('#json').val(jsonStr);
        showResult();
        e.preventDefault();
    });

    $('#btnDownloadLatestPosts').click(function (e) {
        getInstagramData();
        e.preventDefault();
    });

    $('#btnDownloadHighlights').click(function (e) {
        getInstagramData();
        e.preventDefault();
    });

    $('#btnDownloadIgtvVideos').click(function (e) {
        getInstagramData();
        e.preventDefault();
    });

    function generateString(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    async function downloadFile(uri, type = "image/jpeg") {
        let blob = await fetch(uri).then(r => r.blob());
        let data = await (new Response(blob)).text();
        // Create an invisible A element
        const a = document.createElement("a");
        a.style.display = "none";
        document.body.appendChild(a);
        // Set the HREF to a Blob representation of the data to be downloaded
        a.href = window.URL.createObjectURL(
            new Blob([data], {type})
        );
        // Use download attribute to set set desired file name
        let fileName = generateString(5 + ".jpg");
        a.setAttribute("download", fileName);
        // Trigger the download by simulating click
        a.click();
        // Cleanup
        window.URL.revokeObjectURL(a.href);
        document.body.removeChild(a);
    }

    function showAlert(alertText) {
        var errorAlert = '<div id="alert" class="alert alert-warning alert-dismissible fade show" role="alert"><span class="alert-inner--text">' + alertText + '</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        $('#infoBox').html(errorAlert);
        setTimeout(function () {
            $("#alert").hide();
            document.getElementById('input').scrollIntoView();
            $('#infoBox').html('');
            $('button[id^="btn"]').prop('disabled', false);
        }, 2000);
    }

    function showResult() {
        $('button[id^="btn"]').prop('disabled', true);
        $('#infoBox').html('<h2 class="display-3 text-dark"><i class="fas fa-circle-notch fa-spin"></i></h2>');
        document.getElementById('infoBox').scrollIntoView();
        var action = $('#action').val();
        var token = $('#token').val();
        var url = $('#input').val();
        if (url === '') {
            showAlert('Input can not be empty.');
            return;
        }
        var json = $('#json').val();
        if (isValidURL(url) === false) {
            url = 'https://www.instagram.com/' + url;
        } else {
            url = removeURLParameters(url);
        }
        var params = {url: url, action: action, token: token, json: json};
        $.ajax({
            type: "POST",
            url: "system/action.php",
            data: params,
            error: function () {
                var errorAlert = '<div id="alert" class="alert alert-warning alert-dismissible fade show" role="alert"><span class="alert-inner--text">Server error occurred.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $('#infoBox').html(errorAlert);
                setTimeout(function () {
                    $("#alert").hide();
                    document.getElementById('input').scrollIntoView();
                    $('#infoBox').html('');
                    $('button[id^="btn"]').prop('disabled', false);
                }, 2000);
            },
            success: function (data) {
                if (data['medias'] && data['medias'][0] && data['medias'][0]['url'] && isValidURL(data['medias'][0]['url']) && data['user'] && data['user']['username'] && data['user']['username'] != null) {
                    var downloadLinks = '';
                    data['medias'].forEach(function (media) {
                            if (media['url']) {
                                var thumbnail = '';
                                if (media['type'] === 'image' || media['type'] === 'private') {
                                    thumbnail = '<img class="card-img" src="' + media['preview'] + '">';
                                } else if (media['preview']) {
                                    thumbnail = '<img class="card-img" src="' + media['preview'] + '">';
                                    //thumbnail = '<iframe scrolling="no" style="border:0;width:10em" class="card-img" src="' + media['preview'] + '">';
                                } else if (media['preview'] === null && media['url'] && media['type'] === 'video') {
                                    thumbnail = '<video class="card-img"><source src="' + media['url'] + '" type="video/mp4">Your browser does not support the HTML5 video.</video>';
                                }
                                var icon;
                                if (media['type'] === 'image') {
                                    icon = '<i class="fas fa-search-plus"></i>';
                                } else {
                                    icon = '<i class="fas fa-play"></i>';
                                }
                                var downloadLink = '<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 pb-sm"><div class="card bg-default">' + thumbnail + '<div class="card-img-overlay d-flex align-items-baseline"><div class="content"><a target="_blank" href="' + media['url'] + '" class="btn btn-primary btn-sm">' + icon + '</a><a target="_blank" href="' + media['downloadUrl'] + '" class="btn btn-primary btn-sm"><i class="fas fa-download"></i> ' + media['fileType'] + '</a></div></div></div></div>';
                                downloadLinks = downloadLinks.concat(downloadLink);
                            }
                        }
                    )
                    if (data['user']['username'] && data['user']['profilePicUrl']) {
                        var profilePicture = '<iframe scrolling="no" style="min-width: 10em" class="img-thumbnail" src="' + data['user']['profilePicUrl'] + '"></iframe>';
                        //var profilePicture = '<img class="img-thumbnail" src="' + data['user']['profilePicUrl'] + '">';
                        var username = '<h5 class="text-dark mt-3">@' + data['user']['username'] + '</h5>';
                        var userId = '<p class="text-dark mt-0">User ID: ' + data['user']['id'] + '</p>';
                        var followersCount = '<p class="text-dark mt-0"><i class="fas fa-users"></i> ' + formatNumber(data['user']['followers']) + '</p>';
                        var biography = '<p class="text-dark mt-3">' + data['user']['biography'] + '</p>';
                        $('#posterInfo').html(profilePicture + username + userId + followersCount + biography);
                    } else {
                        $('#posterInfo').remove();
                        $("#downloadLinks").attr('class', 'col-12');
                    }
                    if (downloadLinks) {
                        $('#downloadLinks').html(downloadLinks);
                    } else {
                        $('#downloadLinks').html('<div id="alert" class="alert alert-warning alert-dismissible fade show w-100" role="alert"><span class="alert-inner--text">No media found!</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    $('#downloadArea').show();
                    document.getElementById('downloadLinks').scrollIntoView();
                    $('#infoBox').html('');
                    $('button[id^="btn"]').prop('disabled', false);
                } else if (data['error']) {
                    showAlert(data['error']);
                } else {
                    showAlert('Unknown error occurred.');
                }
            }
        });
    }
});