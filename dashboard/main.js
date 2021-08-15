"use strict";

import { server } from "../globals/constants.js";

$(document).ready(()=>{

    const addUsers = $("#add_users");
    const modUsers = $("#mod_users");

    const endpoint = `${server}/test_frontend/back/operations`;

    function getValues(table, index){
        let values = [];
        let children = Array.from($(table.children()).children()[index].children);
            values = children.filter(e => e.firstChild.textContent != "");

        return values.map(el => el.firstChild.textContent);
    }

    function formatValues(typeOfFormat, values){
        const format = {
            type: values[0],
            username: values[1],
            fullname: values[2],
            email: values[3],
            address: values[4],
            phone: values[5],
            password: values[6],
            op: 1
        }

        switch (typeOfFormat) {
            case "add":
                return format;
            case "mod":
                delete format.password;
                return format;
        
            default:
                return;
        }
    }

    function serializeObject(obj){
        return $.param(obj);
    }

    function ajax({url, method, data}){
        return new Promise((res, rej)=>{
            $.ajax({
                url: url,
                method: method,
                dataType: "json",
                data: data
            })
            .done(dt => {
                res(dt);
            })
            .fail(e => rej(e));
        });
    }

    function getElIndex(rows, el){
        return rows.indexOf(el);
    }

    function process(info){
        ajax({url: `${endpoint}/process.php`, method: "POST", data: serializeObject(info)})
        .then(dt =>{
            alert(dt.msg);
        }).catch(e => {console.log(e)});
    }

    $("#add_user").click(()=>{
        const info = formatValues("add", getValues(addUsers, 0x1));

        if(info.type === "admin" || info.type === "seller"){
            process(info);
        }else{
            alert("Solo son admitidos usuarios administradores (admin) y vendedores (seller)");
        }
    });

    $(".update_u").click(e =>{
        const rows = Array.from($("#mod_users tr"));
        const parent = e.target.parentElement.parentElement;
        const index = getElIndex(rows, parent);

        const info = formatValues("mod", getValues(modUsers, index));
              info["op"] = 0x2;
        
        process(info);
    });

    $(".delete_u").click(e =>{
        const conf = confirm("Esta seguro de que desea eliminar el usuario?");

        if(conf){
            const rows = Array.from($("#mod_users tr"));
            const parent = e.target.parentElement.parentElement;
            const index = getElIndex(rows, parent);

            const info = formatValues("mod", getValues(modUsers, index));
                info["op"] = 0x3;
            
            process(info);
        }
    });

});