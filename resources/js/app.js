import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// #################### autocomplete/typeahead for locations ##########################
// jQuery autocomplete to get location name and id from location table with location form input
$(document).ready(function() {

    // this looks like duplicate code but on the create group page, the location input autocomplete in the header
    // was interfering with the location input autocomplete in the form - same target dom elements
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


    // #################### autocomplete/typeahead for locations in header ##########################
    const $locationNameInputHeader = $("#location_name_header");

    $locationNameInputHeader.autocomplete({
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
            $('#location_id_header').val(ui.item.value);
            $('#location_name_header').val(ui.item.label);
            return false;
        }
    });

    // if the location_name field has a city's name, but the user deletes the location/city name
    // delete that location's id from the hidden location_id field
    $locationNameInputHeader.blur(function () {
        if ($(this).val().length === 0) {
            $("#location_id_header").val("");
        }
    });

    // if the location_name field has a city's name, but the user deletes the location/city name
    // delete that location's id from the hidden location_id field
    $locationNameInput.blur(function () {
        if ($(this).val().length === 0) {
            $("#location_id").val("");
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


    // #################### modal dialog launcher ##########################
    $("#dialog").dialog({
        autoOpen: false,
        modal: true
    });

    $("#opener").on("click", function() {
        $("#dialog").dialog("open");
    });

});
