var GiveMe;
GiveMe = {
    imageSized:function (url, width, height, backgroundColor, format) {
        if (!backgroundColor) {
            backgroundColor = "000000"
        }
        if (!format) {
            format = "jpg"
        }
        var mediaFolder = "Site::$mediaFolder";
        var fn;
        fn = "sized";
        var url = mediaFolder + "/cache/img/" + fn + "/" + width + "/" + height + "/" + backgroundColor + "/" + format + "/" + url;
        return url;
    }
};

