<div class="modal fade" id="modalEditComment" role="dialog">
	<div class="modal-dialog">

  	<!-- Modal content-->
      	<div class="modal-content">
       	 	<div class="modal-header">
          		<button type="button" class="close" data-dismiss="modal">&times;</button>
          		<h4 class="modal-title">Voulez-vous vraiment supprimer ce commentaire ?</h4>
        	</div>

	        <form id="formEditComment" class="modal-form" method="post" action="">
	        {!! csrf_field() !!}
		        <div class="modal-body">

			        <div class="row">
			        	<div class="col-lg-10 col-lg-offset-1">
			        		<textarea name="content" id="content"></textarea>
			        	</div>
			        </div>

		        </div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
		          	<button type="submit" class="btn btn-primary">Modifier</button>
		        </div>
			</form>

   		</div>
	</div>
</div>