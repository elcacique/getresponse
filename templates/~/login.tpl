<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>{AUTH_HEADLINE}</title>
<style type="text/css" media="all">
	@import "/css/default.css";
</style>


</head>
<body>

<center>
  <div class="login_div">
    <h2 style="font-size:12px;">{AUTH_HEADLINE}</h2>
    <div align="center">
      <form method="post" action="/{LANG}/page_access.html">
	  <input type="hidden" name="url" value="{URL}"/>
	  <input type="hidden" name="ful_url" value="{FUL_URL}"/>
        <table cellspacing="3" cellpadding="3" border="0" style="margin: 0pt auto;">
          <tbody>
            <tr>
              <td><label>{AUTH_LOGIN}</label> :</td>
              <td><input type="text" size="20" style="width:120px" name="login"/></td>
            </tr>
            <tr>
              <td><label>{AUTH_PASS}</label> :</td>
              <td><input type="password" size="20" style="width:120px" name="password"/></td>
            </tr>
            <tr align="right">
              <td colspan="2"><input type="submit" style="float:left;" value="  {AUTH_LOGIN_BT}  " id="Login"/>
                <input type="submit" name="button_exit" onclick="return hs.close(this); return false" value="  {AUTH_CANCEL}  " id="Login"/></td>
            </tr>
          </tbody>
        </table>
      </form>
	  
    </div>
  </div>
</center>
</body>
</html>
