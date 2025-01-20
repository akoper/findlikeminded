import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function() {

    // #################### autocomplete/typeahead for locations ##########################
    // jQuery autocomplete to get location name and id from location table in search groups on
    // welcome page and create group page
    const $locationNameInput = $("#location_name");

    $locationNameInput.autocomplete({
        source: function (request, response) {
            $.ajax({
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function (data) {
                    // console.log(data)
                    response(data);
                },
                url: "/locations/autocomplete"
            });
        },
        minLength: 2,
        // when user selects city from autocomplete, set id to hidden location_id field and name to location_name field
        select: function( event, ui ) {
            $('#location_id').val(ui.item.value);
            $('#location_name').val(ui.item.label);
            return false;
        }
    });

    // if the location_name field has a city's name, but the user deletes the location/city name
    // delete that location's id from the hidden location_id field
    $locationNameInput.blur(function () {
        if ($(this).val().length === 0) {
            $("#location_id").val("");
        }
    });


    // #############   autocomplete/typeahead for locations in top navigation/header   #################
    // this looks like duplicate code, but on the group create page, the location input
    // autocomplete in the search in the top navigation was clobbering the location input
    // autocomplete in the create groups form in the page body - they had the same target DOM id's
    const $locationNameInputNavigation = $("#location_name_navigation");

    $locationNameInputNavigation.autocomplete({
        source: function (request, response) {
            $.ajax({
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function (data) {
                    // console.log(data)
                    response(data);
                },
                url: "/locations/autocomplete"
            });
        },
        minLength: 2,
        // when user selects city from autocomplete, set id to hidden location_id field and name to location_name field
        select: function( event, ui ) {
            $('#location_id_navigation').val(ui.item.value);
            $('#location_name_navigation').val(ui.item.label);
            return false;
        }
    });

    // if the location_name field has a city's name, but the user deletes the location/city name
    // delete that location's id from the hidden location_id field
    $locationNameInputNavigation.blur(function () {
        if ($(this).val().length === 0) {
            $("#location_id_navigation").val("");
        }
    });

    // #################### autocomplete/typeahead for users ##########################
    const $userNameInput = $("#user_name");

    $userNameInput.autocomplete({
        source: function (request, response) {
            $.ajax({
                data: {
                    term: request.term
                },
                dataType: "json",
                success: function (data) {
                    console.log(data)
                    response(data);
                },
                url: "/users/autocomplete"
            });
        },
        minLength: 2,
        // when user selects city from autocomplete, set id to hidden location_id field and name to location_name field
        select: function( event, ui ) {
            $('#user_id').val(ui.item.value);
            $('#user_name').val(ui.item.label);
            return false;
        }
    });

    // if the location_name field has a city's name, but the user deletes the location/city name
    // delete that location's id from the hidden location_id field
    $userNameInput.blur(function () {
        if ($(this).val().length === 0) {
            $("#user_id").val("");
        }
    });


    // ###########  modal/dialog launcher for 'are you sure you want to delete group'  #############
    // TODO - started but not implemented 1/11/2025
    $("#dialog").dialog({
        autoOpen: false,
        modal: true
    });

    $("#opener").on("click", function() {
        $("#dialog").dialog("open");
    });

});
