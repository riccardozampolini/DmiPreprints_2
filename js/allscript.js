//funzione ordinamento lista utenti
function setOrder() {
  loadingRight(loadRight);
  document.getElementById("f1").submit();
}
//funzione disattivazione checkbox nella ricerca avanzata
function DisAllFields(id) {
  if (id == "all") {
    if (!document.getElementById("h").disabled) {
      document.getElementById("h").disabled = true;
      document.getElementById("t").disabled = true;
      document.getElementById("a").disabled = true;
      document.getElementById("e").disabled = true;
      document.getElementById("y").disabled = true;
      document.getElementById("c").disabled = true;
      document.getElementById("j").disabled = true;
      document.getElementById("i").disabled = true;
    } else {
      document.getElementById("h").disabled = false;
      document.getElementById("t").disabled = false;
      document.getElementById("a").disabled = false;
      document.getElementById("e").disabled = false;
      document.getElementById("y").disabled = false;
      document.getElementById("c").disabled = false;
      document.getElementById("j").disabled = false;
      document.getElementById("i").disabled = false;
    }
  }
}
//funzione controllo registrazione
function chkAccountUpdate() {
  var name = $('#name').val();
  var sname = $('#surname').val();
  var email = $('#email').val();
  var emailo = $('#emailold').val();
  var pwd = $('#pwd').val();
  var pw0 = $('#pw0').val();
  var pw1 = $('#pw1').val();
  var pw2 = $('#pw2').val();
  var n = name.length;
  var s = sname.length;
  var e = email.length;
  var p0 = pw0.length;
  var p1 = pw1.length;
  var p2 = pw2.length;
  if (n == 0 || s == 0 || e == 0) {
    alert("All fields are required!");
    return false;
  } else {
    if (p0 != 0) {
      if (p1 == 0 || p2 == 0) {
        alert("Insert new password!");
        return false;
      } else {
        if (p1 < 6) {
          alert("The password field must contain at least 6 characters!");
          return false;
        } else if (pw1 != pw2) {
          alert("Passwords do not match!");
          return false;
        } else if (name == pw1) {
          alert("The password can not be the name!");
          return false;
        } else if (sname == pw1) {
          alert("The password can not be the surname!");
          return false;
        }
      }
    }
  }
  //array caratteri speciali
  var chars = ["{", "}", "[", "]", "(", ")", "*", "$", "€", "%", "/", "^", "#", "!", "`", "~", "+", "=", "?", "&", " ", '"', "'", ";", ":", "\\", "|"];
  //array caratteri speciali nome e cognome
  var chars1 = ["{", "}", "[", "]", "(", ")", "*", "$", "€", "%", "/", "^", "#", "!", "`", "~", "+", "=", "?", "&", '"', "'", ";", ":", "\\", "|", "@", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
  //controllo campo nome
  for (var i = 0; i < chars1.length; i++) {
    if (name.indexOf(chars1[i]) != -1) {
      alert("The name is not valid!");
      return false;
    }
  }
  //controllo campo cognome
  for (var i = 0; i < chars1.length; i++) {
    if (sname.indexOf(chars1[i]) != -1) {
      alert("The surname is not valid!");
      return false;
    }
  }
  //controllo campo mail
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  if (!reg.test(email)) {
    alert("The email is not valid!");
    return false;
  }
  //
  $("#top_content").load("reserved/edit_account.php", {name: name, surname: sname, mailold: emailo, mail: email, passworddat: pwd, passwordold: pw0, password: pw1}, function () {
  });
}
//funzione cancella account
function chkAccountDelete() {
  var email = $('#email').val();
  var e = email.length;
  if (confirm("WARNING: The operation is not reversible, you want to proceed with the deletion?")) {
    $("#container").load("reserved/delete_account.php", {mail: email}, function () {
    });
  }
}
//funzione reset password login
function chkInsertReset() {
  var pw1 = $('#pw1').val();
  var pw2 = $('#pw2').val();
  var token = $('#tk').val();
  var p1 = pw1.length;
  if (pw1 != pw2) {
    alert("Passwords do not match!");
    return false;
  } else if (p1 < 6) {
    alert("The password field must contain at least 6 characters!");
    return false;
  }
  //
  $("#top_content").load("reserved/insert_new_password.php", {password1: pw1, password2: pw2, tk: token}, function () {
  });
}
//funzione reset password login
function chkReset() {
  var email = $('#email').val();
  var e = email.length;
  if (e == 0) {
    alert("Insert your email!");
    return false;
  }
  //controllo campo mail
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  if (!reg.test(email)) {
    alert("The email is not valid!");
    return false;
  }
  //
  $("#top_content").load("reserved/reset_pass.php", {mail: email}, function () {
  });
}
//funzione controllo login
function chkLogin() {
  var uidV = $('#input_uid').val();
  var pwV = $('#input_pw').val();
  //array caratteri speciali
  var chars = ["{", "}", "[", "]", "(", ")", "*", "$", "€", "%", "/", "^", "#", "!", "`", "~", "+", "=", "?", "&", " ", '"', "'", ";", ":", "\\", "|"];
  //controllo campo username
  for (var i = 0; i < chars.length; i++) {
    if (uidV.indexOf(chars[i]) != -1) {
      alert("The uid is not valid!");
      return false;
    }
  }
  $("#left_content").load("reserved/submit_loginCheck.php", {uid: uidV, pw: pwV}, function () {
    $("#right_content").load("reserved/submit_loginChooser.php");
  });
}
//funzione controllo registrazione
function chkRegistration() {
  var name = $('#name').val();
  var sname = $('#surname').val();
  var email = $('#email').val();
  var pw1 = $('#pw').val();
  var pw2 = $('#pw2').val();
  var n = name.length;
  var s = sname.length;
  var e = email.length;
  var p1 = pw1.length;
  var p2 = pw2.length;
  if (n == 0 || s == 0 || e == 0 || p1 == 0 || p2 == 0) {
    alert("All fields are required!");
    return false;
  } else if (p1 < 6) {
    alert("The password field must contain at least 6 characters!");
    return false;
  } else if (pw1 != pw2) {
    alert("Passwords do not match!");
    return false;
  } else if (name == pw1) {
    alert("The password can not be the name!");
    return false;
  } else if (sname == pw1) {
    alert("The password can not be the surname!");
    return false;
  }
  //array caratteri speciali
  var chars = ["{", "}", "[", "]", "(", ")", "*", "$", "€", "%", "/", "^", "#", "!", "`", "~", "+", "=", "?", "&", " ", '"', "'", ";", ":", "\\", "|"];
  //array caratteri speciali nome e cognome
  var chars1 = ["{", "}", "[", "]", "(", ")", "*", "$", "€", "%", "/", "^", "#", "!", "`", "~", "+", "=", "?", "&", '"', "'", ";", ":", "\\", "|", "@", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
  //controllo campo nome
  for (var i = 0; i < chars1.length; i++) {
    if (name.indexOf(chars1[i]) != -1) {
      alert("The name is not valid!");
      return false;
    }
  }
  //controllo campo cognome
  for (var i = 0; i < chars1.length; i++) {
    if (sname.indexOf(chars1[i]) != -1) {
      alert("The surname is not valid!");
      return false;
    }
  }
  //controllo campo mail
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  if (!reg.test(email)) {
    alert("The email is not valid!");
    return false;
  }
  //
  $("#top_content").load("reserved/add_account.php", {name: name, surname: sname, mail: email, password: pw1}, function () {
  });
}
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
//funzione seleziona tutte checkbox autori
function toggle(source) {
  var aInputs = document.getElementsByTagName('input');
  for (var i = 0; i < aInputs.length; i++) {
    if (aInputs[i] != source && aInputs[i].className == "check") {
      aInputs[i].checked = source.checked;
      evidenziaTr(aInputs[i]);
    }
  }
}
//funzione seleziona tutte checkbox dmitable
function toggleDMI(source) {
  var aInputs = document.getElementsByTagName('input');
  for (var i = 0; i < aInputs.length; i++) {
    if (aInputs[i] != source && aInputs[i].className == "check2") {
      aInputs[i].checked = source.checked;
      evidenziaTr(aInputs[i]);
    }
  }
}
//funzione seleziona tutte checkbox arxivtable
function toggleARXIV(source) {
  var aInputs = document.getElementsByTagName('input');
  for (var i = 0; i < aInputs.length; i++) {
    if (aInputs[i] != source && aInputs[i].className == "check1") {
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
  try {
    var t = document.getElementById('table');
    var t2 = document.getElementById('table1');
    t.onclick = function (e) {
      e = e || event;
      var src = e.target || e.srcElement;
      if (src.tagName == 'INPUT' && src.type == 'checkbox' && src.id != 'tdh') {
        evidenziaTr(src);
      } else {
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
      } else {
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
  } catch(err) {
    try {
      var t = document.getElementById('table2');
      t.onclick = function (e) {
        e = e || event;
        var src = e.target || e.srcElement;
        if (src.tagName == 'INPUT' && src.type == 'checkbox' && src.id != 'tdh') {
          evidenziaTr(src);
        } else {
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
    } catch(err) {
      try {
        var t = document.getElementById('table3');
        t.onclick = function (e) {
          e = e || event;
          var src = e.target || e.srcElement;
          if (src.tagName == 'INPUT' && src.type == 'checkbox' && src.id != 'tdh') {
            evidenziaTr(src);
          } else {
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
      } catch(err) {}
    }
  }
}
//visualizza schermata di caricamento
function loading(id) {
  id.style.display = 'block';
  var t = document.getElementById('firstContainer');
  t.style.display = 'none';
  try {
    var t1 = document.getElementById('form');
    t1.style.display = 'none';
  } catch (err) {
  }
}
//visualizza schermata di caricamento a destra
function loadingRight(id) {
  if (id.style.display != 'block') {
    id.style.display = 'block';
  } else {
    id.style.display = 'none';
  }
  var t = document.getElementById('secondContainer');
  t.style.display = 'none';
  try {
    var t1 = document.getElementById('form');
    t1.style.display = 'none';
  } catch (err) {

  }

}
//avviso di conferma
function confirmLogout() {
  return confirm("Exit?");
}
//controllo categoria visualizza nuova textarea se selezionato altro
function Checkcath(val) {
  var element = document.getElementById('cat');
  if (val == 'category' || val == 'Other')
  element.style.display = 'block';
  else
  element.style.display = 'none';
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
  return confirm("Delete this preprint?");
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
function confirmDelete2() {
  return confirm("Delete this publication?\n(It can not be undone)");
}
function confirmInsert2() {
  return confirm("Update publication information?\n(If you want to upload a new pdf use upgrade function)");
}
function confirmUpgrade() {
  return confirm("Upgrade publication to following version?\n(This is used for the uploading a new pdf, it can not be undone)");
}
function confirmDelete3() {
  return confirm("Remove selected preprints?");
}
function confirmInsert3() {
  return confirm("Insert selected preprints?");
}
function confirmDelete4() {
  return confirm("Remove author/s?");
}
function confirmDelete5() {
  return confirm("Remove all archived preprints?");
}
function confirmDelete6() {
  return confirm("Remove user/s?");
}
