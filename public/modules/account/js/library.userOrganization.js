/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function getUserOrganization() {
    
    $.getJSON('/account/index/viewuserorganization', function (data) {
        
        var body = document.getElementById("id_list_configuration");
        var cellText = "<ul class=\"uk-grid uk-grid-width-1-4 uk-text-center\">";
        $.each(data, function (key, json) {
          cellText+= "<li><div class='uk-panel uk-panel-box uk-panel-box-primary'><a href='/account/index/redirectconfiguration?configuration=" + json[2] + "'>" + json[3] + "</a></div></li>";                
        });
        cellText+= "</ul>";
        body.innerHTML  = cellText;
    });
}

getUserOrganization();