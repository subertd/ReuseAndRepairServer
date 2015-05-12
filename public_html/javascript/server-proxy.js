/**
 * Created by Donald on 5/11/2015.
 */

/**
 * class ServerProxy
 *
 * handles transactions with the server
 *
 * @constructor resolves the constant SERVER_URL based on local environment
 * @depends jQuery
 */
function ServerProxy() {

    const CONFIG_PATH = "javascript/local-config.json";

    var serverUrl;

    $.ajax({
        url: CONFIG_PATH,
        dataType: 'json',
        async: false,
        success: function(data) {
            serverUrl = data['serverUrl'];
        },
        error: function(error) {
            console.log("Error getting local-config.json", error);
        }
    });

    return {
        syncDatabase: function(callback) {
            $.ajax({
                url: serverUrl,
                method: "get",
                success: callback
            });
        },
        insert: function(type, model, callback, errorCallback) {
            $.ajax({
                url: serverUrl,
                method: "post",
                headers: {
                    "action" : type,
                    "contentType": "application/json"
                },
                data: JSON.stringify(model),
                dataType: 'json',

                success: callback,
                error: errorCallback
            });
        }
    }
}