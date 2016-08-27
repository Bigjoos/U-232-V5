    function getname()
    {
        var filename = document.getElementById("torrent").value;
        var filename = filename.toString();
        var lowcase = filename.toLowerCase();
        var start = lowcase.lastIndexOf("\\"); //for Google Chrome on windows
        if (start == -1){
            start = lowcase.lastIndexOf("\/"); // for Google Chrome on linux
            if (start == -1)
                start == 0;
            else start = start + 1;
        }
        else start = start + 1;
        var end = lowcase.lastIndexOf("torrent");
        var noext = filename.substring(start,end-1);
        noext = noext.replace(/H\.264/ig,"H_264");
        noext = noext.replace(/5\.1/g,"5_1");
        noext = noext.replace(/2\.1/g,"2_1");
        noext = noext.replace(/\./g," ");
        noext = noext.replace(/H_264/g,"H.264");
        noext = noext.replace(/5_1/g,"5.1");
        noext = noext.replace(/2_1/g,"2.1");
        document.getElementById("name").value=noext;
    }
