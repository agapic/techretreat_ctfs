<?php
require_once "assets/statusbar.php";
require_once "assets/stalking.php";

if (isset($_GET['password']) && $_GET['password'] == 'https') {
  log_event('[REFERER] Correct password');
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Challenge Complete!</title>
</head>
<body>
<p>Crawl forwards like a
<a href="spider.php">spider</a>.</p>
</body>
</html><?php
  die();
}

log_event('[REFERER] Challenge accepted');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link href="https://cdn.jsdelivr.net/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/octicons/2.4.1/octicons.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="https://cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://cdn.jsdelivr.net/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">

      window.addEventListener("keydown", function(e) {
        if (e.ctrlKey && e.keyCode === 70 || e.keyCode === 114) {
          alert("Ctrl-F may give incorrect results. You've been warned.")
          e.preventDefault();
        }
      });

      /*
       * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
       * Digest Algorithm, as defined in RFC 1321.
       * Version 2.2 Copyright (C) Paul Johnston 1999 - 2009
       * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
       * Distributed under the BSD License
       * See http://pajhome.org.uk/crypt/md5 for more info.
       */

      /*
       * Configurable variables. You may need to tweak these to be compatible with
       * the server-side, but the defaults work in most cases.
       */
      var hexcase = 0;   /* hex output format. 0 - lowercase; 1 - uppercase        */
      var b64pad  = "";  /* base-64 pad character. "=" for strict RFC compliance   */

      /*
       * These are the functions you'll usually want to call
       * They take string arguments and return either hex or base-64 encoded strings
       */
      function hex_md5(s)    { return rstr2hex(rstr_md5(str2rstr_utf8(s))); }
      function b64_md5(s)    { return rstr2b64(rstr_md5(str2rstr_utf8(s))); }
      function any_md5(s, e) { return rstr2any(rstr_md5(str2rstr_utf8(s)), e); }
      function hex_hmac_md5(k, d)
        { return rstr2hex(rstr_hmac_md5(str2rstr_utf8(k), str2rstr_utf8(d))); }
      function b64_hmac_md5(k, d)
        { return rstr2b64(rstr_hmac_md5(str2rstr_utf8(k), str2rstr_utf8(d))); }
      function any_hmac_md5(k, d, e)
        { return rstr2any(rstr_hmac_md5(str2rstr_utf8(k), str2rstr_utf8(d)), e); }

      /*
       * Perform a simple self-test to see if the VM is working
       */
      function md5_vm_test()
      {
        return hex_md5("abc").toLowerCase() == "900150983cd24fb0d6963f7d28e17f72";
      }

      /*
       * Calculate the MD5 of a raw string
       */
      function rstr_md5(s)
      {
        return binl2rstr(binl_md5(rstr2binl(s), s.length * 8));
      }

      /*
       * Calculate the HMAC-MD5, of a key and some data (raw strings)
       */
      function rstr_hmac_md5(key, data)
      {
        var bkey = rstr2binl(key);
        if(bkey.length > 16) bkey = binl_md5(bkey, key.length * 8);

        var ipad = Array(16), opad = Array(16);
        for(var i = 0; i < 16; i++)
        {
          ipad[i] = bkey[i] ^ 0x36363636;
          opad[i] = bkey[i] ^ 0x5C5C5C5C;
        }

        var hash = binl_md5(ipad.concat(rstr2binl(data)), 512 + data.length * 8);
        return binl2rstr(binl_md5(opad.concat(hash), 512 + 128));
      }

      /*
       * Convert a raw string to a hex string
       */
      function rstr2hex(input)
      {
        try { hexcase } catch(e) { hexcase=0; }
        var hex_tab = hexcase ? "0123456789ABCDEF" : "0123456789abcdef";
        var output = "";
        var x;
        for(var i = 0; i < input.length; i++)
        {
          x = input.charCodeAt(i);
          output += hex_tab.charAt((x >>> 4) & 0x0F)
                 +  hex_tab.charAt( x        & 0x0F);
        }
        return output;
      }

      /*
       * Convert a raw string to a base-64 string
       */
      function rstr2b64(input)
      {
        try { b64pad } catch(e) { b64pad=''; }
        var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
        var output = "";
        var len = input.length;
        for(var i = 0; i < len; i += 3)
        {
          var triplet = (input.charCodeAt(i) << 16)
                      | (i + 1 < len ? input.charCodeAt(i+1) << 8 : 0)
                      | (i + 2 < len ? input.charCodeAt(i+2)      : 0);
          for(var j = 0; j < 4; j++)
          {
            if(i * 8 + j * 6 > input.length * 8) output += b64pad;
            else output += tab.charAt((triplet >>> 6*(3-j)) & 0x3F);
          }
        }
        return output;
      }

      /*
       * Convert a raw string to an arbitrary string encoding
       */
      function rstr2any(input, encoding)
      {
        var divisor = encoding.length;
        var i, j, q, x, quotient;

        /* Convert to an array of 16-bit big-endian values, forming the dividend */
        var dividend = Array(Math.ceil(input.length / 2));
        for(i = 0; i < dividend.length; i++)
        {
          dividend[i] = (input.charCodeAt(i * 2) << 8) | input.charCodeAt(i * 2 + 1);
        }

        /*
         * Repeatedly perform a long division. The binary array forms the dividend,
         * the length of the encoding is the divisor. Once computed, the quotient
         * forms the dividend for the next step. All remainders are stored for later
         * use.
         */
        var full_length = Math.ceil(input.length * 8 /
                                          (Math.log(encoding.length) / Math.log(2)));
        var remainders = Array(full_length);
        for(j = 0; j < full_length; j++)
        {
          quotient = Array();
          x = 0;
          for(i = 0; i < dividend.length; i++)
          {
            x = (x << 16) + dividend[i];
            q = Math.floor(x / divisor);
            x -= q * divisor;
            if(quotient.length > 0 || q > 0)
              quotient[quotient.length] = q;
          }
          remainders[j] = x;
          dividend = quotient;
        }

        /* Convert the remainders to the output string */
        var output = "";
        for(i = remainders.length - 1; i >= 0; i--)
          output += encoding.charAt(remainders[i]);

        return output;
      }

      /*
       * Encode a string as utf-8.
       * For efficiency, this assumes the input is valid utf-16.
       */
      function str2rstr_utf8(input)
      {
        var output = "";
        var i = -1;
        var x, y;

        while(++i < input.length)
        {
          /* Decode utf-16 surrogate pairs */
          x = input.charCodeAt(i);
          y = i + 1 < input.length ? input.charCodeAt(i + 1) : 0;
          if(0xD800 <= x && x <= 0xDBFF && 0xDC00 <= y && y <= 0xDFFF)
          {
            x = 0x10000 + ((x & 0x03FF) << 10) + (y & 0x03FF);
            i++;
          }

          /* Encode output as utf-8 */
          if(x <= 0x7F)
            output += String.fromCharCode(x);
          else if(x <= 0x7FF)
            output += String.fromCharCode(0xC0 | ((x >>> 6 ) & 0x1F),
                                          0x80 | ( x         & 0x3F));
          else if(x <= 0xFFFF)
            output += String.fromCharCode(0xE0 | ((x >>> 12) & 0x0F),
                                          0x80 | ((x >>> 6 ) & 0x3F),
                                          0x80 | ( x         & 0x3F));
          else if(x <= 0x1FFFFF)
            output += String.fromCharCode(0xF0 | ((x >>> 18) & 0x07),
                                          0x80 | ((x >>> 12) & 0x3F),
                                          0x80 | ((x >>> 6 ) & 0x3F),
                                          0x80 | ( x         & 0x3F));
        }
        return output;
      }

      /*
       * Encode a string as utf-16
       */
      function str2rstr_utf16le(input)
      {
        var output = "";
        for(var i = 0; i < input.length; i++)
          output += String.fromCharCode( input.charCodeAt(i)        & 0xFF,
                                        (input.charCodeAt(i) >>> 8) & 0xFF);
        return output;
      }

      function str2rstr_utf16be(input)
      {
        var output = "";
        for(var i = 0; i < input.length; i++)
          output += String.fromCharCode((input.charCodeAt(i) >>> 8) & 0xFF,
                                         input.charCodeAt(i)        & 0xFF);
        return output;
      }

      /*
       * Convert a raw string to an array of little-endian words
       * Characters >255 have their high-byte silently ignored.
       */
      function rstr2binl(input)
      {
        var output = Array(input.length >> 2);
        for(var i = 0; i < output.length; i++)
          output[i] = 0;
        for(var i = 0; i < input.length * 8; i += 8)
          output[i>>5] |= (input.charCodeAt(i / 8) & 0xFF) << (i%32);
        return output;
      }

      /*
       * Convert an array of little-endian words to a string
       */
      function binl2rstr(input)
      {
        var output = "";
        for(var i = 0; i < input.length * 32; i += 8)
          output += String.fromCharCode((input[i>>5] >>> (i % 32)) & 0xFF);
        return output;
      }

      /*
       * Calculate the MD5 of an array of little-endian words, and a bit length.
       */
      function binl_md5(x, len)
      {
        /* append padding */
        x[len >> 5] |= 0x80 << ((len) % 32);
        x[(((len + 64) >>> 9) << 4) + 14] = len;

        var a =  1732584193;
        var b = -271733879;
        var c = -1732584194;
        var d =  271733878;

        for(var i = 0; i < x.length; i += 16)
        {
          var olda = a;
          var oldb = b;
          var oldc = c;
          var oldd = d;

          a = md5_ff(a, b, c, d, x[i+ 0], 7 , -680876936);
          d = md5_ff(d, a, b, c, x[i+ 1], 12, -389564586);
          c = md5_ff(c, d, a, b, x[i+ 2], 17,  606105819);
          b = md5_ff(b, c, d, a, x[i+ 3], 22, -1044525330);
          a = md5_ff(a, b, c, d, x[i+ 4], 7 , -176418897);
          d = md5_ff(d, a, b, c, x[i+ 5], 12,  1200080426);
          c = md5_ff(c, d, a, b, x[i+ 6], 17, -1473231341);
          b = md5_ff(b, c, d, a, x[i+ 7], 22, -45705983);
          a = md5_ff(a, b, c, d, x[i+ 8], 7 ,  1770035416);
          d = md5_ff(d, a, b, c, x[i+ 9], 12, -1958414417);
          c = md5_ff(c, d, a, b, x[i+10], 17, -42063);
          b = md5_ff(b, c, d, a, x[i+11], 22, -1990404162);
          a = md5_ff(a, b, c, d, x[i+12], 7 ,  1804603682);
          d = md5_ff(d, a, b, c, x[i+13], 12, -40341101);
          c = md5_ff(c, d, a, b, x[i+14], 17, -1502002290);
          b = md5_ff(b, c, d, a, x[i+15], 22,  1236535329);

          a = md5_gg(a, b, c, d, x[i+ 1], 5 , -165796510);
          d = md5_gg(d, a, b, c, x[i+ 6], 9 , -1069501632);
          c = md5_gg(c, d, a, b, x[i+11], 14,  643717713);
          b = md5_gg(b, c, d, a, x[i+ 0], 20, -373897302);
          a = md5_gg(a, b, c, d, x[i+ 5], 5 , -701558691);
          d = md5_gg(d, a, b, c, x[i+10], 9 ,  38016083);
          c = md5_gg(c, d, a, b, x[i+15], 14, -660478335);
          b = md5_gg(b, c, d, a, x[i+ 4], 20, -405537848);
          a = md5_gg(a, b, c, d, x[i+ 9], 5 ,  568446438);
          d = md5_gg(d, a, b, c, x[i+14], 9 , -1019803690);
          c = md5_gg(c, d, a, b, x[i+ 3], 14, -187363961);
          b = md5_gg(b, c, d, a, x[i+ 8], 20,  1163531501);
          a = md5_gg(a, b, c, d, x[i+13], 5 , -1444681467);
          d = md5_gg(d, a, b, c, x[i+ 2], 9 , -51403784);
          c = md5_gg(c, d, a, b, x[i+ 7], 14,  1735328473);
          b = md5_gg(b, c, d, a, x[i+12], 20, -1926607734);

          a = md5_hh(a, b, c, d, x[i+ 5], 4 , -378558);
          d = md5_hh(d, a, b, c, x[i+ 8], 11, -2022574463);
          c = md5_hh(c, d, a, b, x[i+11], 16,  1839030562);
          b = md5_hh(b, c, d, a, x[i+14], 23, -35309556);
          a = md5_hh(a, b, c, d, x[i+ 1], 4 , -1530992060);
          d = md5_hh(d, a, b, c, x[i+ 4], 11,  1272893353);
          c = md5_hh(c, d, a, b, x[i+ 7], 16, -155497632);
          b = md5_hh(b, c, d, a, x[i+10], 23, -1094730640);
          a = md5_hh(a, b, c, d, x[i+13], 4 ,  681279174);
          d = md5_hh(d, a, b, c, x[i+ 0], 11, -358537222);
          c = md5_hh(c, d, a, b, x[i+ 3], 16, -722521979);
          b = md5_hh(b, c, d, a, x[i+ 6], 23,  76029189);
          a = md5_hh(a, b, c, d, x[i+ 9], 4 , -640364487);
          d = md5_hh(d, a, b, c, x[i+12], 11, -421815835);
          c = md5_hh(c, d, a, b, x[i+15], 16,  530742520);
          b = md5_hh(b, c, d, a, x[i+ 2], 23, -995338651);

          a = md5_ii(a, b, c, d, x[i+ 0], 6 , -198630844);
          d = md5_ii(d, a, b, c, x[i+ 7], 10,  1126891415);
          c = md5_ii(c, d, a, b, x[i+14], 15, -1416354905);
          b = md5_ii(b, c, d, a, x[i+ 5], 21, -57434055);
          a = md5_ii(a, b, c, d, x[i+12], 6 ,  1700485571);
          d = md5_ii(d, a, b, c, x[i+ 3], 10, -1894986606);
          c = md5_ii(c, d, a, b, x[i+10], 15, -1051523);
          b = md5_ii(b, c, d, a, x[i+ 1], 21, -2054922799);
          a = md5_ii(a, b, c, d, x[i+ 8], 6 ,  1873313359);
          d = md5_ii(d, a, b, c, x[i+15], 10, -30611744);
          c = md5_ii(c, d, a, b, x[i+ 6], 15, -1560198380);
          b = md5_ii(b, c, d, a, x[i+13], 21,  1309151649);
          a = md5_ii(a, b, c, d, x[i+ 4], 6 , -145523070);
          d = md5_ii(d, a, b, c, x[i+11], 10, -1120210379);
          c = md5_ii(c, d, a, b, x[i+ 2], 15,  718787259);
          b = md5_ii(b, c, d, a, x[i+ 9], 21, -343485551);

          a = safe_add(a, olda);
          b = safe_add(b, oldb);
          c = safe_add(c, oldc);
          d = safe_add(d, oldd);
        }
        return Array(a, b, c, d);
      }

      /*
       * These functions implement the four basic operations the algorithm uses.
       */
      function md5_cmn(q, a, b, x, s, t)
      {
        return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s),b);
      }
      function md5_ff(a, b, c, d, x, s, t)
      {
        return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t);
      }
      function md5_gg(a, b, c, d, x, s, t)
      {
        return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t);
      }
      function md5_hh(a, b, c, d, x, s, t)
      {
        return md5_cmn(b ^ c ^ d, a, b, x, s, t);
      }
      function md5_ii(a, b, c, d, x, s, t)
      {
        return md5_cmn(c ^ (b | (~d)), a, b, x, s, t);
      }

      /*
       * Add integers, wrapping at 2^32. This uses 16-bit operations internally
       * to work around bugs in some JS interpreters.
       */
      function safe_add(x, y)
      {
        var lsw = (x & 0xFFFF) + (y & 0xFFFF);
        var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
        return (msw << 16) | (lsw & 0xFFFF);
      }

      /*
       * Bitwise rotate a 32-bit number to the left.
       */
      function bit_rol(num, cnt)
      {
        return (num << cnt) | (num >>> (32 - cnt));
      }


      function submitForm() {
        var pwd = document.getElementById('password').value;
        if (hex_md5(pwd + 'salt') === '65872ffcf6b2989e1419413a9bb794bc') {
          document.getElementById('rsform').submit();
        } else {
          alert("That's not correct.");
        }
      }
    </script>

    <style type="text/css">
      .referred {
        font-size: 1px;
        color: white;
        position: fixed;
        top: -100px;
        left: -100px;
      }
    </style>
  </head>
  <body>
    <header class="container">
      <h1>Referer Spam</h1>
    </header>

    <p class="referred">
      referer is one of those examples of an incorrect spelling that stuck.
      referer referer referer.
    </p>

    <main class="container">
      <p>
        The password consists of the first five lowercase letters that follow
        the 443<sup>rd</sup> occurrence of the substring <q>referer</q> in the
        below. The substring will always be lowercase, and will not be
        interrupted by any other characters.
      </p>

      <p>
        (Note: this is a coding challenge. The title is a joke; <q>referer</q>
        is not a misspelling, and none of this flavour is relevant to your
        answer.)
      </p>

      <p>
        Raw file <a href="raw.bin">here.</a>
      </p>

      <form action="cantthinkofagoodname.php" method="get" id="rsform">
        <p>Password: <input type="text" name="password" id="password" />
          <button onclick="submitForm();">Submit</button></p>
      </form>

      <pre><!--
-->refererxIerefererfN0cIVrefererqSBKZSBrefererPi1
NQP
.HNtreferercr2I
ck
uYbjRUzb
MIreferer
referer3iWVrnNm9tN
WNJJDarefererPTlyC
eBl
rreferertX02nuk4Sb
HTDVBwreferer81i4noOreferer
o1refererCIreferere
refererzmCP
LVFvXreferer
X
OCPPX7GUhIY
icmkdSwalrefererareferer
y0a6hvkNYsQ
XFLM
mrefererrefererX
jrrefererBGrefererneiyv9S8YmrghjrefererZQ6nWreferer
xYmf2CxlJ
OojlSJireferercxo+DMn
w0q9OrefereriqAwLsANihdBe19refererbJdA5k5iECm2
csOKVUTwVrefererp
PCyXgU+LrefererzrefererQ8a5dgB.dwg3

XGDYrefererR2QK
7qc8m
Ureferer6Ubn.EQREAu
lc0refererAEQivb89eaW0rgQdareferer6NMwXHB+E6ukz+2e5l5DreferercHJA

.gyJU7+u29refererAs0mD28QFX5iJMEDDxDJ1rreferer
e0xBl
WRjhBrefererjjXIU
etrefereri05ouiWa9s
PsErefererz
+le
referer7refererqcj

Rreferer
N
lrefererOyCSarefererVA8Ohd9+Wuiz.pNqNSdsdQ
refererTuvO2ihrVjOfwrefererNNzL
3+iI
ws4BC.osrefererI8vf2UP3tH
DYDB8H+
kgBM7refererjBR0.8n1kw.eSbesPCDSJvzHrefererA1P
refererc7VHzzW5V
xrefererj
y
e3hitX9Tl
c
m
89x
E0referer
3krefererx+
FDVEaLknrefererfd0zRJv
5Pju8x0
6.
xDt
referer8ij8kB02tGjrx83piVIKrefererMK+xle9refererr9AMAh
vibqTF

kI
XPrreferer5H5m2hYRqZR0VIrefereroHeqeI
hmzVIrefererB1RsvQJrefererN+UJrefererX0VDpIM8
AgS0md3luQrefererF
o6k7hHjI2Swd65g9refererx
55NBvQ44xJPjLcq0refererxqXqr7RiDurXZGtDl43
sreferercj3c+FqXs
WiS
UW4SHrefererrefererkv+refererE

KPreferero
JvKbCfauereferer8xj
MfF8H7bCreferer
t26drefererRreferersiwxLn
pjyuLrefereraIgX9
2jh3hHx
PzTuc
+creferer
9D6mv
dpVyvgciiNt9MboUQrefererQCtxIowYPrefererCcpI
3w9srefererNnW
refererw
Ga8DreferersniB9SGo0zusCSsXejpeZx0Vreferermqs21GYE.u
cB
E
jzjPw
drefererF
IBTrefererK
Ts
j5WoRt
s9m
hWv.8refererY9goRzUJArefererU2A
FlGxMMg3
PyDrrefereryEHG3referer4WAm8nc
.freferer
2WtrefereroWtaX0Q9FJlGElqpyKs
orefererMA
fzVm4yjj+AccrefererH3TVuZpR3K1
refererbreferer
referermu
nSeHuO
t
Gz
qrefererkL+OR8xpHc8NV87AmMreferervCibfyqkfQcuKsprefererrzTX.+
DGsRrefererrefereraELVF1Vbhar5a7IrefererA
GoOwk1zcoInuOluVMOCfjreferermYrefererWpq0tq
pNbnkbrefererL.mEM
bmIRdy.ESllX4lvYrefererjnkFkDYl
zLj2SCb
TrefererBSQPHD
fEJuA+aT


36referero1.jrefererAbZ
iC6hSW0dGreferer
xVtr6F2SJwsbGereferer+
YA+ww8FrefererhgUCjVXsoTpk
Pqm
cezS+Hreferer4LD8gX.Fi8referercI1JbQLuhvQ6A3.n20

+ILkreferereTlmH8Screfererw
LRXgWJJusQymmsjZ32refererDkjZTeNKUg
9fbQ2W7refererreferergBFg++KDMMAdFO9JEreferer1Oft0sQ7yeea
Bip3WX7Rreferer3KTUJvKVYfwuTE0o4sM
bArefererXIe28refererxEscIFAD0EVFzw0W0VrefererYY5fp7gp
mCRZreferer+GYa81fnlHMW1kDirefererwWu9OCrefererHRt1
8lqKJfZ
0refererwupP8DUreferernAhukvXjrefererQ
vh51x
A
4QG+wpX+vUrefererWrZeEmfgi

D
DrqL
33.referer8u


5nBPjDxWrefererv
b9kayrefererms4yqgt1
EsU+20FvPiQFWQtrefererP
+vhgxiwLZCrefereraHUaG
Hrefereryuh0lIt30g
UR
23RMrefererzvoyE
A3MZIbvwr
0refererDPUJd0IvKDLx9referer
RKlt
F3zJ.refererU+wekCLU
sloLerefereraX.DUQBj9lsoUtt24refererNI
K31hycQWreferer7h
5mnrefererMjYnBzwBnTJWSvrefererWo.GQkbYdf6d7qO9aSY1refereraoO4CqP0+refererrCureferer
3rUkqoAXaJ
QR8
QZrefererkOUY4r9ekAWhRB
iimnq1referer
qNVKG9refererS
y0
q
GrrefererT5Y

QZzPzV
freferer
refererg+Vg15J
MEV4KI6referer3gf6uprefererORdF

sGPDCJs54.6Xreferer1
TrefererHODkrefererRX79YDi
9MrrENEB3JrefererlcVLHD0+
refererDMF.sdmQ2ww4x
NLqqrefererveiIoe
refererYRs

qSTMnf2referer

fvqreferer
FVzFvTg7BTPrefererJsvrefererctv
refererA55pRp+MrefererklvDIoIK2z
6hLA.
KquB
Ybreferere
fSoVgbrefererJjrefererCvreferer5M
Q4refererS0zsLPoxv
IoI5areferer9+vn4.NVs
GKJ0YrefererX1Uu
xvHf
rozi4INAZrefererCWkrefererWUjbkBR


Eo73rillFT
WreferermmShSO9
9p7
bmuyJGrefererYM+gr2MRfreferer3r85URc
FIBVba
.referer9eta
L0z89y



To.QrefererH9mkEj

GBKmreferer4DfqS4xdEreferergxAgBnreferer8WgCL2H
DAJA0d
rKreferertbQSreferer4bjSD5BCZOhrefererFr
eIlcjvc
t
CGJwSRMUaEPrefererC+dSQsfH2kov2D9
yC
yWQrefererG0h
Iv
referer4YA
referer3j
XQb
dLE
sEPEZUCd0xreferersaSgxNoSdfJ09FrefererH
Zw078vGL

bbwAyIACgJAreferers6uoKrE
oDeArefererFFrrUEMXp5A6Xd+h.Aird0refererkpu
.JpBPkXXArefererp.roaRExDtBUpRwRca07YTH
refererGxzyQOjrwFs1HcC05TEZrefererxtSH
lRPh
A9gKew94pg
5Rrefererp
Qpq1Lrefererz
frefererA3zwNo3MdzbXCcNHZtalrefererpkQ91qBreferergEdljcR6tK0
refererCscm3R3KpNM1yx7Tbreferer
zVq.6aEMO4LR7JjwoqM
PgrefererUR67dhCMUO8ClWrefererN4i
MmM34Qmvbn
8iFmrefererv

8vDMN
zwCH9refererZSE
o.pYu26FfY
refererNSNvB
+fr2u4kareferer39LAq2z
referera+dO5GyrefererWG
dPqOS
refererYv3k
7uzJ
I
ptj

G2A5
Irefererx.bE
vAn1refererfe3YHIL.qXCVm054
gg4PGZprefererBy9zbU
yK
8
D9rDZ.dRrefererdDVreferer3fHyMrefererzj.T
U
rTfizmzrefererLHH
kznNVArefererv+Hb3VpcxiYhZ
NxirefererJ4ujyk8CQ
3
mEtrefereriwckGEI
K
5tzm7AZ
XirefererCcIClzYfdftOz+obG
5refererOrefererO
I0oHjANreferer
etwW+PNUy2eWWPM3refererE
773Z
S7
C9t1MdhOTQreferer
SvTJVd

oYk71Gd
refererGt6referer
ZWTgOrefererrefererwrefererVNMGvMRZ8ZkFvVMy98refererShlXPK0refererAusHM8SMn
bP
yF5eQcO0referer6qAFOXQCXiVm
QERAANB6fgOrefererbs2mXeq1k1
a1kxL
xseErefererjyqRB3refererrefererO
FHrMfph3vrefererOmOb
saVlTkWJ0r
krefererC6refererpWUMdLXx7DnTf
refererIGitrefererreferer2refererXrefererfGRZ
efgjQl
Xreferer
g
pJArefereriVL
refererb
nuVU++S27fbrefererdb
SkYM3Uc
uAreferer3Ovp+refererqq6oSYTrefererGy6Burefererz4j7CaJkmrDrorR
alrefererj
UWk55tT3JS
Y8YxTx+refererMOV8oc8U7H
8McM
IOh3dwZreferer849gJ
qUHLWS
nBFA9MkqPrefererot1wPK2
qSOs
iZiPN
J3refererDFFkmZJ4cf7xJ
R7TfXreferer47refereriCndmXpkR+mrefererFddpu
chXvreferer
oNZj62woI0On6UBi3xan0Ereferer
d4IQcsdK4Np8WN4dy7TRreferer
bK
Poeg86
nC
0hBHJkuInrefererSRbTjw4C3Ku
Gk+CY
refererVpjS6XH37ehcEmAmrefererqNb
+
9refererPG
4mjl4In
n6refererxRfWbjK0wjlEv01u
GO6Srefererq7VMm6BTJb7
refererN6
dereferer7J
Yo5refererioAtQ5c3fTafD48KvP7a8referer6nCPSDR1VgrXcOOrefererbApQ
gnDzTidreferernrefererijvGJJt5PfTq5sJYreferer8OdFVrefererId1Djz
59
En97yHW3XyelrefererH
N
bvUcwwouOUreferertljNPgU5EOYslh
referersnHZpgfhrefererITZ
MrqD
d5J3
UiGbrefererzE
NrefererloPrefererkyh84
1
w.1St0Gam7AIrgdQrefererlM3aZWb+3f5PYSBlg
d1lz6ereferergEy
lc
T
dDOMrefereriwL+
9
Op

Wtj8aZ
GGC5MrefererQS
lrefererrefererQSmO

Lg
Erefererreferer
X
h0r
EV
sdxJJ3referereU3Orefererm
q5WvZfzrefererUVIOwyJSB0refererrbLo
vKK7j
k3refererrefererGKpjCbt
refererZ
qCrefererz9
P7mo3sum7P3drefererbclBP
nheYU69Crefererk
ep
+E.c4HH
hqBTTZTcreferer
SED1SYcpKereferer
sMZjBWaD8jOq

refererrlAtGrefererQQDtjXBD
referer
C

OreferernXiIVSBH5ObSreferer1nhFrefererrefererS
bRIqkZLByDYfm7OfrefererrefererGS4HFeb1N
aFrefererJKoEO
AkgFARMqznHLgHprJrefererTz3zP
reUcrefererU3SHB0PraK

9Ml
p3
fGrefererqn9+DrefereroY60L29refererPCLYFKq
1referern
ce7eWB879Ef1CIvG
refererrefererUT5tKBJYBreferereB
Wj
bEZf
.H
WkcgrefererNqcEuNd35l
xSRarefererv8ZGeV7
jgmCrefererT7Pk
4GwipUmI1referernp

.JbNK2rkEH
PY2sGM7refererwtK5a06TYMArefererX
0g0rrefererZErXy534vDnKOsreferer4refererhb2cj1u7Z0E3+NJ2dxucrefererJC
WD
imp48t+r
zreferer

GHtF
LQUuf3YQTgmjreferer02wso
hVJrefererqY

zmDdy0FuNfs
referertL
SEitQNy
qv
p6refererOQWXreferer8+ryj
z3B8lrjreferer

brefererWt
qYj
gRzd
sz

DNTrefererylDqhVe

ZyFtfXgQ0Ptrefererojoj0nUxr

referer
w6MHrrefererrurlA1oreferer0QGoYKwbhZ
.WZ12MQZrreferer
kDrefererU1refererShBreferer
G
Uz+9bUn+uZHdM6BrefererXKAPup
M5Dp

8pi
FyGrefereri
z
lrefererNqUCrefererGzwt919O

64678refererR9
yEkE4refererHaYpAYL

4f
56
tu
W.JtrefererrwFEhXC9gdTIcqEIeJNerefererxiiyorefererEreferer9RaX
Y1b4xVl3k+08qOwIPfZrefererOreferern0ysAEY
5CrCWWrefererr
jCrefererJkF9
JyrefererU34fZLreferer9tjB
jf8.1vVLZI0okX8IrefererTHfzxuxXreferermGSreferer
SjsnFNS3sAdsQy

referer2YvnIP12wmT
+vxw
0p
I.c
refererLvA7i
q+Axi3zo
6zreferer
5TORWerefererdN
9A7J


6vZ13areferer

CiiBnCQhWOnOrefererx5ouoYoCBl
UwVHrefererLhgThreferer0qs
OLnmRcO4J+LjNCV

xrefererbKzqf38XVreferer
06CblCtwEDF
9wDfs.m47urefererxJv
wJ+Cy14FSI
5refererGM.VBRWkkrVmsF7I
refererrefererT
cIhl
CgdGZEnG9JmVagp

refererJ+wUX7biAv1
gOz
A0StuCn
referer3gU
referer

9dMWU77mAJxV7+eaDcz
referer6j
jk+lU
49Gn7
hSCB+YrefererWs
zibsc
ZxC
AnJmP0ix9referer7Cp7EWccF1refererp4avNG
0refererOIbERaKerefererXPsO1Treferernae.I7c4fmEeQkxf
ZC9referer
JaQ6gFlWpD
QMvDiwhrrrefererC
CeQrefereruZuTBeTACO
olMk1gC
refererareferer
p8gB
EF87Q
F5VXSGjPZ7Ureferer9
A
PkCmG0.SqsJ1oyYjrefererhFJ6HHzcf1
CTB4
xK0HN3H1refererwMbnV7CZE
FSr3F
DQxFVQvreferers+EJYUs
Lq6refererRswXnhsq

pYrefererxrefererD
U+x
q5B+
34cAlc
0PwrefererO
OV
referer6IEVL
sM5U
NS
.m5ec442Goreferer5referer2o
lrU+refererl
uIGzamFZY
B7
KhrefereryoreferermHC5HGBreferer
R8z1refererkRf2NK+g.
fcz6acHps5
IE0referero
F6VcW0Preferer7+r.referer
ekp.eBE

73XPDYreferer
OB691ib5
imvOKd9tOzEYrefererCrefererCk749YrefererzreferervSDwKn
XsuMmh
+iFBrRkcreferervT
F3VAT7mMA4mKk44O8refererl
h
C4
cb.2TyG9

5frefererEQsxqzXJ9Q7HdyWrefererbwunrefererQGj2rFwk6Hsrefererj5pQynP26UEh
ehArefererREaZLAuO0fN2dGmwYam
YCwbrefererg
ajTS3tC+.+dsePsdNY
crefererD8
ejgF3a4t
4
DK1kreferero1dV
5Aq3B7A
RN8qVlDU4greferer.h+tKtEp
sxc.refererq4YW6C2t3
8x9HxR4h5k1NMqrefererbPw
WrefererG
pKX+refererU
wA4DP.xE
refererrYtRYKiLA2p
Q2HsPS0
ed4refererXB6q9RBAtXWn0Ac.kCrefererws
N6NMh
LC0
Cr7YzErefererIWvI


CXW3aC9jD+referer+7ae7M
z3NX
refererzjFVXrefererC
46mqOBakZGlUD
lalik
referer+SCy6poR79A9QDVnodA3
XF
referer
VDV5Ah
UNv.
OzISJ
referer
6dU
XXrefererh
rgR
sOFYi7referermPmR
Q7h
TxMrefereraPs
Oreferer9refererfgSoykL.i7s
B

referer5.o7cnRJreferergXq
MIY
q+8BLGEIrefererrefereryBbU
bRHe
bzgFk0LYlg1refererrefererkiRHsnJQ1Fs5gQBZg1dEkrefererged2referermG
43
9u0kcrz
fFreferer
0.tRrefererNiIV
LWrefererP0referer6FvZNnQMQBreferer48WeCOiEIg.4gao.referer
iofw
UaKpkw5Miyo9mZ
0IlrefererME7rreferernFmbaS
BCreferer0C2
qoTrefererJ
5IT8
DQQyRCDPrefererY
otcfp
z6

3greferer
0
sstS0referer4A
V4g4MjxsLBx97AsNilUdgrefererrefererreferer4referer8qxRe0UA
48ImrT3WIarhJprefererV
BHqRnyty3qDrefererw
p0yQ
CL+mpQuErefererWdnJ1.ZvPCbM
JZ0referer

MUT
dfNuenM.Kz6E
referere.JQJ
O3UoUWQMreferer+G
V4t+refererB.refererBGJflreferer8referer4EnyoBHcXWreferer0x
TwG5
refererF8VCx5xreferera3.2xx7wf.b9tfrefererb
lUa10refererVDs31Y8frKnflbrefererX
7qwqV
wFreferer
refererpVJG
Lw
Kw5KhAG6xS
gn1anrefererOLWAz3X1AskJUkYQjPKzQprefereroT18QAd
e
refererUW11
RtnKhzH8H7+qQreferer


TEE5emrefererKX3dRH5AE8Q
roIqzn
cq0referer77GWmos
2WyVq8
urefererbP+L
I0RQv7xqx5QzfMWx1kWrefererS
x
Sreferer
MSu
G
b6o5hdGeh
9SYigYrefererOCu3t0lreferer
rh
nv
pHUxYsf
IrefererOjbNOcrefererO3UPYaWrNZ
sErefererw
0aucnH6Creferer
jE8
Zj42Ue6
XLUkgmrrefererMzYmrefererjh.3n9
0thxkj1refererzr46hotIJVpmfLreferer1SBTFNNf
ts2
V7E3kdreferer5hUrefererRb
ZDy6
p7xKIxbP
xOO
LreferersPp
zH2K8Ofi4U
GrqpytrefererOrK03sWz7EPfWrI0sltzreferer5jjHwjlAK3LJSTH9R4Erefererx28XlF7Vrefererk5.bLl
ST8jd
jjreferereyMkqKVV
kMANyG2
lrefererqdbVhi03
ydh4D2pd.QT4ErefererwQE
gq

W
w2nFWrarefererVgRr0prefererDUB
03uPVM
wrefererPQreferertkiYYp2Eyzy4zJOb3freferergb.ZJ94Gsp
8g
vMO4D
refererrefererzU9
w5referer6
xEHz70QrCTL
c
pjarefererKu3Ab2
WEKE.nUv67<!--
   --></pre>
    </main>

    <p>This is the end of the page. Good luck!</p>

    <?php statusbar(93); ?>

    <script src="https://cdn.jsdelivr.net/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>
