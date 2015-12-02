//setta i cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
//legge i cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
//cookie istruzioni fulltext search
function checkCookie() {
    var adv = getCookie("adv");
    if (adv == "") {
        alert("EXAMPLE OF USING BOOLEAN OPERATORS(full text search):\n'Milan Rome': this must be one of the two terms.\n'+Milan +Rome': must be present both terms.\n'+Milan Rome': there must be 'Milan' and possibly 'Rome'.\n'+Milan -Rome': there must be 'Milan' but not 'Rome'.\n'+Milan +(<Rome >Venice)': must be present or 'Milan' and 'Rome' or 'Milan' and 'Venice', but the records with 'Milan' and 'Venice' are of greater. ('<' Means less important, '>' means greater relevance).\n'''Milan Rome''': This must be the exact sequence 'Milan Rome'.\n");
        setCookie("adv", "yes", 15);
    }
}
//avviso cookie impostazioni
function checkCookie1() {
    var adv = getCookie("opt");
    if (adv == "") {
        alert("This settings use cookies, your preferences will remain stored in your browser.");
        setCookie("opt", "yes", 15);
    }
}
//cookie pageview
function checkCookie3() {
    var pageview = getCookie("pageview");
    if (pageview == "0") {
        setCookie("pageview", "1", 1825);
        alert("On page view is now abilited, PDF will be shown in the page!");
        window.location.reload();
    } else {
        adv.style.display = 'none';
        setCookie("pageview", "0", 1825);
        alert("On page view is now disabled!");
        window.location.reload();
    }
}
//settaggio cookie pageview
function checkCookie4() {
    setCookie("pageview", "0", 1825);
    window.location.reload();
}
//cookie searchbar in tutte le pagine
function checkCookie6() {
    var pageview = getCookie("searchbarall");
    if (pageview == "0" || pageview == "") {
        setCookie("searchbarall", "1", 1825);
        setCookie("searchbar", "1", 1825);
        alert("Search Bar is now abilited on all pages, now the bar will appear on every page!");
        window.location.reload();
    } else {
        setCookie("searchbarall", "0", 1825);
        alert("Search Bar is now disabled on all pages, now the bar will appear only in this page!");
        window.location.reload();
    }
}
//cookie searchbar in tutte le pagine
function checkCookie7() {
    setCookie("searchbarall", "0", 1825);
    alert("Search Bar is now disabled on all pages, use settings menu to riactivate!");
}
//visualizza ricerca avanzata
function showHide(id) {
    if (id.style.display != 'block') {
        id.style.display = 'block';
    } else {
        id.style.display = 'none';
    }
}
//opzioni di visualizzazione ricerca tutte le pagine
function showHide2(id, id2) {
    checkCookie();
    showHide(id);
    showHide(id2);
}
//visualizza opzioni
function showHide3(id, id2, id3) {
    checkCookie();
    id.style.display = 'none';
    id2.style.display = 'none';
    if (id3.style.display != 'block') {
        id3.style.display = 'block';
    } else {
        id3.style.display = 'none';
    }
}
//visualizza ricerca avanzata
function showHide4(id, id2, id3) {
    checkCookie();
    id3.style.display = 'none';
    if (id.style.display != 'block') {
        id.style.display = 'block';
        id2.style.display = 'block';
    } else {
        id.style.display = 'none';
        id2.style.display = 'none';
    }
}
//chiudi menu click fuori dalla finestra
function myFunction() {
    adv.style.display = 'none';
    adv2.style.display = 'none';
    opt.style.display = 'none';
}
//chiudi menu click fuori dalla finestra
function myFunction2() {
    adva.style.display = 'none';
    adv2a.style.display = 'none';
}
//funzione searchbar fixed
$(document).ready(function () {
    var s = $("#sticker");
    var pos = s.position();
    $(window).scroll(function () {
        var windowpos = $(window).scrollTop();
        if (windowpos >= pos.top) {
            s.addClass("stick");
        } else {
            s.removeClass("stick");
        }
    });
});
//funzione visualizza freccia torna su 
$(document).ready(function () {
    var s = $("#gotop");
    var pos = s.position();
    $(window).scroll(function () {
        var windowpos = $(window).scrollTop();
        if (windowpos >= 120) {
            s.addClass("gotopview");
        } else {
            s.removeClass("gotopview");
        }
    });
});
//funzione animazioni scrolling
$(document).ready(function () {
    //Check to see if the window is top if not then display button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#scrollToTop').fadeIn();
        } else {
            $('#scrollToTop').fadeOut();
        }
    });
    //funzione click per lo scrolling
    $('#scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
});
//text area category
(function () {
    window.UpdateMathcat = function (TeX) {
        //set the MathOutput HTML
        document.getElementById("categorydiv").innerHTML = TeX;
        //reprocess the MathOutput Element
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, "categorydiv"]);
    }
})();
//text area title
(function () {
    window.UpdateMathtit = function (TeX) {
        //set the MathOutput HTML
        document.getElementById("titlediv").innerHTML = TeX;
        //reprocess the MathOutput Element
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, "titlediv"]);
    }
})();
//text area authors
(function () {
    window.UpdateMathaut = function (TeX) {
        //set the MathOutput HTML
        document.getElementById("authordiv").innerHTML = TeX;
        //reprocess the MathOutput Element
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, "authordiv"]);
    }
})();
//text area journal
(function () {
    window.UpdateMathjou = function (TeX) {
        //set the MathOutput HTML
        document.getElementById("journaldiv").innerHTML = TeX;
        //reprocess the MathOutput Element
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, "journaldiv"]);
    }
})();
//text area comments
(function () {
    window.UpdateMathcom = function (TeX) {
        //set the MathOutput HTML
        document.getElementById("commentsdiv").innerHTML = TeX;
        //reprocess the MathOutput Element
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, "commentsdiv"]);
    }
})();
//text area abstract
(function () {
    window.UpdateMathabs = function (TeX) {
        //set the MathOutput HTML
        document.getElementById("abstractdiv").innerHTML = TeX;
        //reprocess the MathOutput Element
        MathJax.Hub.Queue(["Typeset", MathJax.Hub, "abstractdiv"]);
    }
})();
//avviso di conferma
function confirmLogout()
{
    return confirm("Exit?");
}
//controllo categoria
function Checkcath(val) {
    var element = document.getElementById('cat');
    if (val == 'category' || val == 'Other')
        element.style.display = 'block';
    else
        element.style.display = 'none';
}
//funzione seleziona tutte checkbox
function toggle(source) {
    var aInputs = document.getElementsByTagName('input');
    for (var i = 0; i < aInputs.length; i++) {
        if (aInputs[i] != source && aInputs[i].className == source.className) {
            aInputs[i].checked = source.checked;
            evidenziaTr(aInputs[i]);
        }
    }
}
//evidenzia elementi selezionati
function evidenziaTr(ck) {
    var flag = ck.checked
    while (ck = ck.parentNode) {
        if (ck.tagName == 'TR') {
            ck.className = (flag) ? 'on' : '';
        }
    }
}
//script che evidenzia righe selezionate
window.onload = function () {
    var t = document.getElementById('table');
    var t2 = document.getElementById('table1');
    t.onclick = function (e) {
        e = e || event;
        var src = e.target || e.srcElement;
        if (src.tagName == 'INPUT' && src.type == 'checkbox' && src.id != 'tdh') {
            evidenziaTr(src);
        }
        else {
            if (src.tagName != 'A' && src.id != 'tdh') {
                var found = true;
                while (src.tagName != 'TR') {
                    if (src == t) {
                        found = false;
                        break;
                    }
                    src = src.parentNode;
                }
                if (found) {
                    var els = src.getElementsByTagName('input');
                    for (var k = 0, l = els.length; k < l; k++) {
                        if (els[k].type == "checkbox") {
                            els[k].checked = !els[k].checked;
                            evidenziaTr(els[k]);
                        }
                    }
                }
            }
        }

    }
    t2.onclick = function (e) {
        e = e || event;
        var src = e.target || e.srcElement;
        if (src.tagName == 'INPUT' && src.type == 'checkbox' && src.id != 'tdh') {
            evidenziaTr(src);
        }
        else {
            if (src.tagName != 'A' && src.id != 'tdh') {
                var found = true;
                while (src.tagName != 'TR') {
                    if (src == t) {
                        found = false;
                        break;
                    }
                    src = src.parentNode;
                }
                if (found) {
                    var els = src.getElementsByTagName('input');
                    for (var k = 0, l = els.length; k < l; k++) {
                        if (els[k].type == "checkbox") {
                            els[k].checked = !els[k].checked;
                            evidenziaTr(els[k]);
                        }
                    }
                }
            }
        }

    }
}
//visualizza schermata di caricamento
function loading(id) {
    if (id.style.display != 'block') {
        id.style.display = 'block';
    } else {
        id.style.display = 'none';
    }
}
//messaggi di avviso
function confirmDownload() {
    var x = confirm("Warning! this overwrite the existent data and will take more time, continue?");
    if (x) {
        loading(load);
        return x;
    } else {
        return x;
    }
}
function confirmInsert() {
    return confirm("Are you sure?");
}
function confirmDelete() {
    return confirm("Delete this paper?");
}
function confirmExit() {
    var x = confirm("All unsaved changes will be lost, continue?");
    if (x) {
        loading(load);
        return x;
    } else {
        return x;
    }
}
function confirmDelete2()
{
    return confirm("Delete this publication?\n(It can not be undone)");
}
function confirmInsert2()
{
    return confirm("Update publication information?\n(If you want to upload a new pdf use upgrade function)");
}
function confirmUpgrade()
{
    return confirm("Upgrade publication to following version?\n(This is used for the uploading a new pdf, it can not be undone)");
}
function confirmDelete3()
{
    return confirm("Remove selected papers?");
}
function confirmInsert3()
{
    return confirm("Insert selected papers?");
}
function confirmDelete4()
{
    return confirm("Remove author/s?");
}
function confirmDelete5()
{
    return confirm("Remove all archived papers?");
}
