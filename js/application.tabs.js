/*******************************************************************/
/* Tabs/Page control */

/* [Permissions checked!] */

App.Tabs = {};
App.Tabs.activate = function(b,sso) {
    $("#test-connection").hide();
    var d = $(b).parent().parent();
    if (!d) {
        return ;
    }
    App.Dropdowns.closeAll();
    var e = d.children(".tab-header").find("a");
    e.removeClass("current");
    $(b).addClass("current");
    var c = $(b).attr("class").split(" ");
    $.each(c, function(f, g) {
      if(g==="tab10" && sso !== "none"){
        $("#test-connection").show();
        $('#' + sso).show();
      }
        if (g.substr(0, 3) == "tab") {
            var a = d.children(".tab-body");
            a.children("div.tab").hide();
            a.children("div." + g).show();
            return false;
        }
    });
    return false
};


App.Tabs.isActive = function(a)
{
      return $(a).hasClass('current');
}

;

