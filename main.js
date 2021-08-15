"use strict";

import { server } from "./globals/constants.js";

$(document).ready(()=>{

    const endpoint = `${server}/test_frontend/back/login.php`;

    $("#login").click(ev =>{
        ev.preventDefault();
        
        $.ajax({
            url: endpoint,
            method: "POST",
            dataType: "json",
            data: $("#form").serialize()
        })
        .done(dt => {
            if(dt.status === "success"){
                location.href = `${server}/test_frontend/dashboard/index.php`;
            }else{
                alert(dt.msg);
            }
        })
        .fail(e => {console.log(e)});

    });

});