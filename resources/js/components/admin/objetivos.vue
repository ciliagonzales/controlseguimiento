<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
			 <div class="col-md-12">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<button  class="btn btn-outline-primary" @click="ocultar('1')">
							Objetivos <i class="fa fa-plus"></i>
							</button>
							<button  class="btn btn-outline-primary" @click="ocultar('2')">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
				</div>
	            <div class="card card-default"  id="objetivo">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">OBJETIVOS</h4>  
	                </div>
					<div class="card-body">
	                    <form @submit.prevent="RegistrarObjetivo" method="POST" id="carga">
	                        <div class="row">
	                            <div class="col-md-4">
	                                <div class="form-group">
	                                    <label>Oficina</label>
										<select v-model="objetivo.oficina" class="form-control">
											<option v-for="o in oficinas" :key="o.IDOficina" :value="o.IDOficina">
												{{o.NombreOficina}}		
											</option>
										</select>
	                                </div>
	                            </div>
                                <div class="col-md-8">
	                                <div class="form-group">
	                                    <label>Objetivo</label>
	                                    <input type="text" v-model="objetivo.objetivo" class="form-control"   maxlength="100">
	                                </div>
	                            </div>
							</div>
							<div class="row text-left">
								<div class="col-md-2">
									<input type="submit" value="Registrar" class="btn btn-success">
								</div>
							</div>
							<div class="clearfix"></div>
	                    </form>
						<div class="col-md-12" id="editar">
							<div class="row">
								<div class="col-md-10">
									<div class="form-group">
										<label>Objetivo</label>
										<input type="text" v-model="objetivo.objetivo" class="form-control">
									</div>
								</div>
							</div>
							<div class="row">
								<button class="btn btn-outline-success" @click="editar()">Guardar Cambios</button>
							</div>
						</div>
	                </div>
				</div>
			</div>
	    	</div>
			<div class="row">
			 <div class="col-md-12">
				<div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">OFICINAS VS OBJETIVOS</h4>  
	                </div>
	                <div class="card-body">
						<div class="content table-responsive table-full-width">
                            <v-client-table :data="objetivos" :columns="columns" :options="options">
								<div slot="Acciones" slot-scope="props">
								<button class="btn btn-danger" data-toggle="tooltip" v-on:click="deleteObjetivo(props.row.ID)" data-placement="left" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button>
								<button class="btn btn-info" data-toggle="tooltip" v-on:click="editObjetivo(props.row.ID)" data-placement="left" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                </div>
						    </v-client-table>
                        </div>
					</div>
	    		</div>
			 </div>
			</div>	
	</div>
    </div>	
</template>

<script>
    export default {
    data() {
        return {
			objetivo:{
                oficina:null,
                objetivo:null,
			},
			objetivos:[{
				ID:null,
				oficina:null,
                objetivo:null,
            }],
            columns: ["oficina","objetivo","Acciones"],
            options: {
				headings:
				{
					oficina: "Oficina",
					objetivo: "Objetivo",
					Acciones: "Acciones",
					
				},
				sortable    : ["oficina","objetivo"],
				filterable  : ["oficina","objetivo"]
			},
			oficinas:[],
			id:null,
        }
	},
	created(){
        this.getDatos();
        this.getObjetivos();
	},
	mounted(){
		$('#objetivo').hide();
		$('#editar').hide();
	},
    methods: {
		getDatos()
        {
            axios.get("getOficinas")
            .then(data=>
            {
                this.oficinas = data.data.oficinas;
                console.log(this.oficinas);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        getObjetivos()
        {
            axios.get("getObjetivos")
            .then(data=>
            {
                this.objetivos = data.data.objetivos;
                console.log(this.objetivos);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
		RegistrarObjetivo()
		{
			axios.post("addObjetivo",{
				objetivo:this.objetivo
			}).then(data=>{
				console.log(data);
				swal({
					position: 'top-end',
					type: 'success',
					title: 'Datos ingresados correctamente',
					showConfirmButton: false,
					timer: 2000
				});
				setTimeout(() => {
					location.reload();
				}, 1500);
			}).catch(error=>{
				console.log(error);	
				swal({
					type: 'error',
					title: 'Error',
					text: 'Verifique los campos los campos obligatorios',
					showConfirmButton: true,
				});
			})
		},
		ocultar(id){
			if(id == '1')
			{
				$('#objetivo').show();
			}
			else if(id == '2')
			{
				$('#objetivo').hide();	
			}
			
		},
        deleteObjetivo(id)
        {
            swal({
                title: '¿Deseas eliminar este Objetivo?',
                text: "No será posible revertir esta acción!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, elíminalo!',
                cancelButtonText: 'No, cancelar!',
            }).then((result) => {
                if (result.value) {
                    axios.get(`/deleteObjetivo/${id}`)
                        .then(data => {
                        if(data.data=="OK"){
                            swal(
                            'Eliminado!',
                             'El Objetivo ha sido eliminado.',
                             'success'
                                );
                            setTimeout(() => {
                                location.reload();
                                this.getData();
                            }, 1500);
                        }
                        }).catch(error => {
                            console.log('Ocurrio un error ' + error);
                            this.$Progress.fail();
                        });
                     }
                });
		},
		editObjetivo(id)
		{
			$('#objetivo').show();
			$('#carga').hide();
			$('#editar').show();
			this.id = id;
			axios.get("getObjetivo/"+id)
            .then(data=>
            {
                this.objetivo.objetivo = data.data.des;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		editar()
		{
			
			axios.get("updateObjetivo/" + this.id + '/' + this.objetivo.objetivo)
            .then(data=>
            {
				this.objetivo.objetivo = null;
				this.getObjetivos();
				console.log(data.data);
				$('#objetivo').hide();
				$('#carga').show();	
				$('#editar').hide();	
            }
            ).catch(error=>{
                console.log(error);
            })
		}
    }
}
</script>
