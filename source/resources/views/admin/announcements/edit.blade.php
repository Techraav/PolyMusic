<div class="container">
    <div class="jumbotron">
        <h1 align="center">Modifier une annonce</h1>
        
        <form class="form-horizontal" role="form" method="post" action="{{ url('admin/announcements/edit') }}">
            {!! csrf_field() !!}

            <div class="form-group">

              <div class="col-md-10 col-md-offset-1">
                <input type="text" class="form-control" name="title" required value="{{ $announcement->title }}">
              </div>
            </div>

            <div class="form-group">

                <div class="col-md-10 col-md-offset-1">
                    <textarea class="form-control" rows="10" name="content" required>{{ $announcement->content }}</textarea>
                </div>
            </div>
            
            <div class="form-group buttons">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>        
    </div>   

</div> 
