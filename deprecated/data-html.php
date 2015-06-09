<?php

session_start();

if (isset($_SESSION['username'])&&isset($_SESSION['password'])) {
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Corvallis Reuse and Repair App</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="../public_html/javascript/server-proxy.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>



<div>
<table class="header" style="width:100%;">
	<tr>
		<td class="header" style="width:33%">
			<h3>Database Management <h3>
		</td>
		<td class="header" style="width:42%">
			<?php
			echo '<h3>Welcome, '.$_SESSION['username'].'</h3>';
			?>
		</td>
		<td class="header" style="width:25%">
			<h3><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Refresh Page</a>&emsp;<a href="../public_html/logout.php">Log out</a></h3>
		</td>
	</tr>
</table>	
</div>


    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2>Organizations</h2>
                <button id="addOrganizationButton" class="btn btn-standard" data-toggle="modal" data-target="#addOrganizationModal">
                    Add Organization
                </button>
                <br><br>
                <ul id="organizationsList" class="list-group"></ul>
                <div id="addOrganizationModalTarget"></div>
                <div id="editOrganizationModalTarget"></div>
                <script type="text/javascript">

$(document).ready(function() {

    var organizationsList = $("#organizationsList");

    /**
     * show the modal and populate the form with existing values
     */
    organizationsList.on('click', 'li span.edit', function() {
        var curOrganizationId = $(this).parent().val();
        var curOrganization = ($.grep(organizations, function(e) {
            return e.id == curOrganizationId;
        }))[0];

        $("#editOrganizationId").val(curOrganizationId);
        $("#editOrganizationName").val(curOrganization.name);
        $("#editOrganizationPhoneNumber").val(curOrganization.phoneNumber);
        $("#editOrganizationWebsiteUrl").val(curOrganization.websiteUrl);
        $("#editOrganizationPhysicalAddress").val(curOrganization.physicalAddress);

        $("#editOrganizationModal").modal('show');
    });

    organizationsList.on('click', 'li span.remove', function() {

        var index = $(this).parent().val();

        serverProxy.deleteOrganization(
            { 'id': index },
            function(data, status) {
                console.log("AJAX success for delete organization", data, status);
                if (data['success']) {
                    syncOrganizations();
                }
                else {
                    alert("Unable to delete organization");
                    // TODO use bootstrap alerts
                }
            },
            function(jqXHR, textStatus, errorThrown) {
                console.log("Error syncing organizations", textStatus, errorThrown);
            }
        );
    });
});

function syncOrganizations() {
    serverProxy.getOrganizations(
        function(data, status) {
            console.log("AJAX success for syncOrganizations", data, status);
            organizations = data;
            populateOrganizationsList();
        },
        function(jqXHR, textStatus, errorThrown) {
            console.log("Error syncing organizations", textStatus, errorThrown);
        }
    );
}

function populateOrganizationsList() {
    $("#organizationsList").empty();
    organizations.forEach(function(organization) {
        var listItem = $(document.createElement('li'));
        listItem.addClass("list-group-item");
        listItem.attr("value", organization['id']);
        listItem.html("<span class='edit'>" + organization['name'] + "</span><span class='badge remove'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></div>");
        $("#organizationsList").append(listItem);
    });
}

/**
 * @citation http://stackoverflow.com/questions/18908531/true-client-side-html-includes
 */
$(function(){
    $("#addOrganizationModalTarget").load("partials/addOrganizationModal.html", function(){
        $(this).contents().unwrap();
    });
});

/**
 * @citation http://stackoverflow.com/questions/18908531/true-client-side-html-includes
 */
$(function(){
    $("#editOrganizationModalTarget").load("partials/editOrganizationModal.html", function(){
        $(this).contents().unwrap();
    });
});
                </script>
            </div><!-- column -->
            <div class="col-md-4">
                <h2>Categories</h2>
                <button id="addCategoryButton" class="btn btn-standard" data-toggle="modal" data-target="#addCategoryModal">
                    Add Category
                </button>
                <br><br>
                <ul id="categoriesList" class="list-group"></ul>
                <div id="addCategoryModalTarget"></div>
                <div id="editCategoryModalTarget"></div>
                <script type="text/javascript">

$(document).ready(function() {

    var categoriesList = $("#categoriesList");

    // When a categories list item is clicked, open the edit category modal
    categoriesList.on('click', 'li span.edit', function() {

        var curCategoryId = $(this).parent().val();
        var curCategory = $.grep(categories, function(category) {
            return category.id == curCategoryId;
        })[0];

        $("#editCategoryId").val(curCategoryId);
        $("#editCategoryName").val(curCategory.name);

        $("#editCategoryModal").modal('show');
    });

    // When the remove button for a categories list item is pressed, use AJAX to remove the category from the server
    // and refresh the list
    categoriesList.on('click', 'li span.remove', function() {

        serverProxy.deleteCategory(
            { 'id': $(this).parent().val() },
            function(data, status) {
                console.log("AJAX success for delete category", data, status);
                if (data['success']) {
                    syncDatabase();
                }
                else {
                    alert("Unable to delete category");
                    // TODO use bootstrap alerts
                }
            },
            function(jqXHR, textStatus, errorThrown) {
                console.log("Error deleting category", textStatus, errorThrown);
            }
        );
    })
});

function syncCategories() {
    serverProxy.getCategories(
        function (data, status) {
            console.log("AJAX success for syncCategories", data, status);
            categories = data;
            populateCategoriesList();
        },
        function(jqXHR, textStatus, errorThrown) {
            console.log("Error syncing categories", textStatus, errorThrown);
        }
    );
}

function populateCategoriesList() {
    $("#categoriesList").empty();
    categories.forEach(function(category) {
        var listItem = $(document.createElement('li'));
        listItem.addClass("list-group-item");
        listItem.attr("value", category['id']);
        listItem.html("<span class='edit'>" + category['name'] + "</span><span class='badge remove'><span class='glyphicon glyphicon-remove'></span></span>");
        $("#categoriesList").append(listItem);
    });
}

/**
 * @citation http://stackoverflow.com/questions/18908531/true-client-side-html-includes
 */
$(function(){
    $("#addCategoryModalTarget").load("partials/addCategoryModal.html", function(){
        $(this).contents().unwrap();
    });
});

/**
 * @citation http://stackoverflow.com/questions/18908531/true-client-side-html-includes
 */
$(function(){
    $("#editCategoryModalTarget").load("partials/editCategoryModal.html", function(){
        $(this).contents().unwrap();
    });
});
                </script>
            </div><!-- column -->
            <div class="col-md-4">
                <h2>Items</h2>
                <button id="addItemButton" class="btn btn-standard" data-toggle="modal" data-target="#addItemModal">
                    Add Item
                </button>
                <br><br>
                <ul id="itemsList" class="list-group"></ul>
                <div id="addItemModalTarget"></div>
                <div id="editItemModalTarget"></div>
                <script type="text/javascript">

$(document).ready(function() {

    var itemsList = $("#itemsList");

    // When an item list item is clicked, show the modal to edit the item
    itemsList.on('click', 'li span.edit', function() {

        var curItemId = $(this).parent().val();
        var curItem = ($.grep(items, function(e) {
            return e.id == curItemId;
        }))[0];

        $("#editItemId").val(curItemId);
        $("#editItemName").val(curItem.name);

        $("#editItemModal").modal('show');
    });

    // When the remove button of an item list item is clicked, use AJAX to remove the item and refresh the list
    itemsList.on('click', 'li span.remove', function() {
        serverProxy.deleteItem(
            { 'itemId': $(this).parent().val() },
            function(data, status) {
                console.log("AJAX success for deleteItem", data, status);
                if (data['success']) {
                    syncDatabase();
                }
                else {
                    alert("Unable to delete the item");
                    // TODO use bootstrap alerts
                }
            },
            function(jqXHR, textStatus, errorThrown) {
                console.log("Error deleting item", textStatus, errorThrown);
            }
        );
    })
});

function populateItemsList() {

    // Alphabetize by name
    items.sort(function(lhs, rhs) {
        var nameL = lhs['name'].toUpperCase();
        var nameR = rhs['name'].toUpperCase();

        if (nameL < nameR) {
            return -1;
        }
        else if (nameL > nameR) {
            return 1;
        }
        else {
            return 0;
        }
    });

    // Append each item to the list
    $("#itemsList").empty();
    items.forEach(function(item) {
        var listItem = $(document.createElement('li'));
        listItem.addClass("list-group-item");
        listItem.attr("value", item['id']);
        listItem.html("<span class='edit'>" + item['name'] + "</span><span class='badge remove'><span class='glyphicon glyphicon-remove'</span></span>");
        $("#itemsList").append(listItem);
    });
}

/**
 * @citation http://stackoverflow.com/questions/18908531/true-client-side-html-includes
 */
$(function(){
    $("#addItemModalTarget").load("partials/addItemModal.html", function(){
        $(this).contents().unwrap();
    });
});

/**
 * @citation http://stackoverflow.com/questions/18908531/true-client-side-html-includes
 */
$(function(){
    $("#editItemModalTarget").load("partials/editItemModal.html", function(){
        $(this).contents().unwrap();
    });
});
                </script>
            </div><!-- column -->
        </div><!-- row -->
        <script type="text/javascript">

var serverProxy = new ServerProxy();

var organizations = [];
var categories = [];
var items = [];
var itemCategories = [];
var organizationReuseItems = [];
var organizationRepairItems = [];

function syncDatabase() {
    serverProxy.syncDatabase(
        function (data, status) {
            console.log("AJAX success for syncDatabase", data, status);

            if (data['success']) {
                organizations = data['organizations'];
                categories = data['categories'];
                items = data['items'];
                itemCategories = data['itemCategories'];
                organizationReuseItems = data['organizationReuseItems'];
                organizationRepairItems = data['organizationRepairItems'];

                populateOrganizationsList();
                populateCategoriesList();
                populateItemsList();
            }
            else {
                alert("Unable to sync database");
                // TODO use bootstrap alert
            }
        },
        function (jqXHR, textStatus, errorThrown) {
            console.log("Error syncing database", textStatus, errorThrown);
        }
    );
}

$(document).ready(function() {
    syncDatabase(); // when the page first loads, sync the database
});
        </script>
    </div><!-- container -->
</body>
</html>

<?php
	
}
else {
	include('redirect.php');
}
?>