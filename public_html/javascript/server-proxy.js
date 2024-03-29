/**
 * Created by Donald on 5/11/2015.
 */

/**
 * class ServerProxy
 *
 * handles transactions with the server
 *
 * @constructor resolves the server url
 * @depends jQuery
 */
function ServerProxy() {

    var serverUrl = "data.php";

    var ajaxToServer = function(method, type, model, callback, errorCallback) {
 
        if (model) {
            model.userId = localStorage.getItem("userId");
            model.sessionToken = localStorage.getItem("sessionToken");
        }

        console.log("model: ", model, JSON.stringify(model));

        $.ajax({
            url: serverUrl,
            method: method,
            headers: {
                "action" : type,
                "contentType": "application/json"
            },
            data: JSON.stringify(model),
            dataType: 'json',
            success: callback,
            error: errorCallback
        });
    };

    return {
        syncDatabase: function(callback, errorCallback) {
            ajaxToServer("get", "sync", null, callback, errorCallback);
        },

        insertOrganization: function(organization, callback, errorCallback) {
            ajaxToServer("post", "organization", organization, callback, errorCallback);
        },
        updateOrganization: function(organization, callback, errorCallback) {
            ajaxToServer("put", "organization", organization, callback, errorCallback);
        },
        deleteOrganization: function(organization, callback, errorCallback) {
            ajaxToServer("delete", "organization", organization, callback, errorCallback);
        },
        getOrganizations: function(callback, errorCallback) {
            ajaxToServer("get", "organization", null, callback, errorCallback);
        },

        insertCategory: function(category, callback, errorCallback) {
            ajaxToServer("post", "category", category, callback, errorCallback);
        },
        updateCategory: function(category, callback, errorCallback) {
            ajaxToServer("put", "category", category, callback, errorCallback);
        },
        deleteCategory: function(category, callback, errorCallback) {
            ajaxToServer("delete", "category", category, callback, errorCallback);
        },
        getCategories: function(callback, errorCallback) {
            ajaxToServer("get", "category", null, callback, errorCallback);
        },

        insertItem: function(item, callback, errorCallback) {
            ajaxToServer("post", "item", item, callback, errorCallback);
        },
        updateItem: function(item, callback, errorCallback) {
            ajaxToServer("put", "item", item, callback, errorCallback);
        },
        deleteItem: function(item, callback, errorCallback) {
            ajaxToServer("delete", "item", item, callback, errorCallback);
        },
        getItems: function(callback, errorCallback) {
            ajaxToServer("get", "item", null, callback, errorCallback);
        }
    }
}
