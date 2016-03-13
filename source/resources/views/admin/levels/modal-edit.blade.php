<!-- Modal -->
<div class="modal fade" id="modalEdit" role="dialog">
	<div class="modal-dialog">

  	<!-- Modal content-->
      	<div class="modal-content">
       	 	<div class="modal-header">
          		<button type="button" class="close" data-dismiss="modal">&times;</button>
          		<h4 id="modal-title" class="modal-title">Modifier le level</h4>
        	</div>

	        <form id="edit-form" class="form form-hozitontal modal-form" method="post" action="{{ url('admin/levels/edit') }}">
	        {!! csrf_field() !!}
	<br/>
				<div class="row">
					<div class="col-lg-11 col-lg-offset-1">
						<label class="col-lg-2">Level :</label>
						<div class="form-group col-lg-8">
							<input required disabled class="form-control" type="text" name="id" id="id" placeholder="Level" value=""/>
						</div>
					</div>

					<div class="col-lg-11 col-lg-offset-1">
						<label class="col-lg-2">Nom :</label>
						<div class="form-group col-lg-8">
							<input required class="form-control" type="text" name="name" id="name" placeholder="Nom" value=""/>
						</div>
					</div>

					<div class="col-lg-11 col-lg-offset-1">
						<label class="col-lg-2">Infos :</label>
						<div class="form-group col-lg-8">
							<textarea cols="50" class="form-control" type="text" name="infos" id="infos" placeholder="Informations"> </textarea>
						</div>
					</div>
				</div>

		        <div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
		          	<button type="submit" class="btn btn-primary">Modifier	</button>
		        </div>
			</form>

   		</div>
	</div>
</div>