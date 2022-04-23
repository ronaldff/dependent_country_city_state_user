<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
    <style>
        .loader {
          border: 16px solid #f3f3f3;
          border-radius: 50%;
          border-top: 16px solid #3498db;
          width: 120px;
          height: 120px;
          -webkit-animation: spin 2s linear infinite; /* Safari */
          animation: spin 2s linear infinite;
          position: absolute;
          top: 60%;
          left: 45%;
        }
        
        /* Safari */
        @-webkit-keyframes spin {
          0% { -webkit-transform: rotate(0deg); }
          100% { -webkit-transform: rotate(360deg); }
        }
        
        @keyframes spin {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
        </style>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="loader" style="display:none"></div>
                <h1 class="text-center">Users</h1>
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">NAME</th>
                        <th scope="col">EMAIL</th>
                        <th scope="col">COUNTRY</th>
                        <th scope="col">STATE</th>
                        <th scope="col">CITY</th>
                        <th scope="col">ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (count($users) > 0)
                            @php $i = 1; @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->country_name }}</td>
                                    <td>{{ $user->state_name }}</td>
                                    <td>{{ $user->city_name }}</td>
                                    <td>
                                        <button class="btn btn-warning" onclick="editUsers({{ $user->id }})">Edit</button>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        @else
                            <tr>
                                <td>Users Not Found</td>
                            </tr>
                        @endif
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body"id="modelData"></div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        function editUsers(user_id)
        {
            $('.modal').modal('hide');
            $("#modelData").html("");
            $(".loader").hide();

            let token = $('meta[name="csrf-token"]').attr('content');
            let userid = user_id;

            $.ajax({
               type:'POST',
               url:'{{ route('edit') }}',
               data:{
                   _token : token,
                   userid : user_id
               },
               dataType : 'html',
               beforeSend: function() {
                $(".loader").show(); 
                },
               success:function(data) {
                $(".loader").hide();
                    $("#modelData").append(data);
                    $('.modal').modal('show');
                }
            });
                // alert(user_id);
        }

        $(document).on('change','#country_dropdown',function(){
            var country_id = this.value;
            $("#state-dropdown").html('');
            $.ajax({
                url:"{{route('getState')}}",
                type: "POST",
                data: {
                country_id: country_id,
                _token: '{{csrf_token()}}' 
                },
                dataType : 'json',
                success: function(result){
                $('#state-dropdown').html('<option value="">Select State</option>'); 
                $.each(result.states,function(key,value){
                $("#state-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
                });
                $('#city-dropdown').html('<option value="">Select State First</option>'); 
                }
            });
        });

        $(document).on('change','#state-dropdown',function(){
            var state_id = this.value;
            $("#city-dropdown").html('');
            $.ajax({
                url:"{{route('getCity')}}",
                type: "POST",
                data: {
                state_id: state_id,
                _token: '{{csrf_token()}}' 
                },
                dataType : 'json',
                success: function(result){
                    $('#city-dropdown').html('<option value="">Select City</option>'); 
                    $.each(result.cities,function(key,value){
                        $("#city-dropdown").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            });
        });

   
    </script>
    <script>
     
    </script>
  </body>
</html>