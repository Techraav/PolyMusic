<div class="modal fade" id="modalDeleteAnnouncement" role="dialog">
	<div class="modal-dialog">

  	<!-- Modal content-->
      	<div class="modal-content">
       	 	<div class="modal-header">
          		<button type="button" class="close" data-dismiss="modal">&times;</button>
          		<h4 class="modal-title">Voulez-vous vraiment supprimer cette annonce ?</h4>
        	</div>

	        <form id="formDeleteAnnouncement" class="modal-form" method="post" action="">
	        {!! csrf_field() !!}
		        <div class="modal-body">
        		<p class="text-danger"><b>Attention ! Cette action est irréversible !</b></p>
		         	<input hidden value="" name="announcement_id" id="announcement_id" />
		        </div>
		        <div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
		          	<button type="submit" class="btn btn-primary">Supprimer</button>
		        </div>
			</form>

   		</div>
	</div>
</div>