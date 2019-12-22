$(document).ready(function () {
    var obj = {
        hideAlert: function(){
            var alert = $("#error");
            alert.hide();
        },

        showAlert: function(){
            var self = this;
            var alert = $("#error");
            alert.show();
            setTimeout(self.hideAlert, 3000);
        },

        getGuestBook: function () {
            var self = this;

            $.ajax({
                url: 'guestBooks',
                type: "GET",
                success: function (data){
                    self.hideAlert();
                    self.showGuestBook(data);
                },
                error: function(data){
                    self.showAlert();
                }
            });
        },

        saveGuestBook: function(data){
            var self = this;

            $.ajax({
                url: 'guestBooks/create',
                type: "POST",
                data: data,
                success: function (data){
                    self.hideAlert();
                    self.showGuestBook(data);
                    $("#name").val('');
                    $("#body").val('');
                },
                error: function(data){
                    self.showAlert();
                }
            });
        },

        showGuestBook: function(data){
            var guestbook = $("#guestbook");
            guestbook.empty();
            for(var i = 0; i<data.length; i++){
                var row = $("<tr></tr>")
                    .append(
                        $('<td></td>').text(data[i]['name'])
                    )
                    .append(
                        $('<td></td>').text(data[i]['dtime'])
                    )
                    .append(
                        $('<td></td>').text(data[i]['body'])
                    );
                guestbook.append(row);
            }
        },

        init: function(){
            var self = this;
            this.getGuestBook();
            $("#save").on('click', function () {
                self.saveGuestBook({
                    name: $("#name").val(),
                    body: $("#body").val(),
                });
                return true;
            });
        }
    }.init();
});