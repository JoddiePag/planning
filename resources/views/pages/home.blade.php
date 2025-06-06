<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Planinako</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="antialiased">
   
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="check-all"></th>
                        <th>#</th>
                       
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($dentiste as $d)

                        <tr>
                            <td><input type="checkbox" class="check-item"></td>
                            <td>{{$d->nom}}</td>
                            <td>{{$d->prenom}}</td>
                            <td>{{$d->email}}</td>
                            <!-- <td>{{$d->nom}}</td>
                            <td>{{$d->nom}}</td> -->
                            <td>
                                <a href="/show/{{$d->id}}" class="edit-link">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                @endforeach
                

                  
                </tbody>
                
                
            </table>

            {{-- Pagination --}}
            <!-- <div class="pagination">
               
                    <a href="" class="btn btn-secondary">Précédent</a>
            
                <span></span>
                
            </div> -->
      
    </div>
    
   
</body>
</html>