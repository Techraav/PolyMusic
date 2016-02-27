<!-- Modal -->
<div class="modal fade" id="modalEdit" role="dialog">
	<div class="modal-dialog">

  	<!-- Modal content-->
      	<div class="modal-content">
       	 	<div class="modal-header">
          		<button type="button" class="close" data-dismiss="modal">&times;</button>
          		<h4 id="modal-title" class="modal-title">Modifier la catégorie</h4>
        	</div>

	        <form id="edit-form" class="form modal-form form-horizontal" method="post" action="{{ url('admin/departments/edit') }}">
	        {!! csrf_field() !!}
	        <br />
	

				<div class="row">
					<input hidden name="category_id" id="category_id" value="" />		        
					<div class="col-lg-10 col-lg-offset-1">
						<label class="col-lg-3 control-label">Nom :</label>
						<div class="form-group col-lg-9">
							<input required class="form-control" type="text" name="name" id="name" placeholder="Nom" value=""/>
						</div>
					</div>

					<div class="col-lg-10 col-lg-offset-1">
						<label class="col-lg-3 control-label">Acronyme :</label>
						<div class="form-group col-lg-9">
							<input required class="form-control" type="text" name="short_name" id="short_name" placeholder="Acronyme" value=""/>
						</div>
					</div>

				</div>
			    <br />

		        <div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
		          	<button type="submit" class="btn btn-primary">Modifier	</button>
		        </div>
			</form>

   		</div>
	</div>
</div>