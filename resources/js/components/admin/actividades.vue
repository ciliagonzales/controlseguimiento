<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<button  class="btn btn-outline-primary" @click="ocultar('1')">
						ACTIVIDADES <i class="fa fa-plus"></i>
						</button>
						<button  class="btn btn-outline-primary" @click="ocultar('2')">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			 <div class="col-md-12" id="objetivo">
	            <div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">ACTIVIDADES</h4>  
	                </div>
					<div class="card-body">
	                    <form @submit.prevent="RegistrarActividad" method="POST" id="carga">
	                        <div class="row">
	                            <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Oficina</label>
										<select v-model="actividad.oficina" class="form-control" @change="objetivos()">
											<option v-for="o in oficinas" :key="o.IDOficina" :value="o.IDOficina" >
												{{o.NombreOficina}}		
											</option>
										</select>
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Objetivo</label>
										<select v-model="actividad.objetivo" class="form-control" @change="zprocesos()">
											<option v-for="z in objetivosL" :key="z.ID" :value="z.ID">
												{{z.Descripcion}}		
											</option>
										</select>
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Proceso Estratégico</label>
                                        <select v-model="actividad.proceso" class="form-control">
											<option v-for="o in procesosL" :key="o.ID" :value="o.ID">
												{{o.Descripcion}}		
											</option>
										</select>
                                    </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Actividad</label>
	                                    <input type="text" v-model="actividad.actividad" class="form-control"   maxlength="100">
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
	                                    <label>Actividad</label>
	                                    <input type="text" v-model="actividad.actividad" class="form-control"   maxlength="100">
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
	                    <h4 class="title">LISTA DE ACTIVIDADES</h4>  
	                </div>
	                <div class="card-body">
						<div class="content table-responsive table-full-width">
                            <v-client-table :data="actividades" :columns="columns" :options="options">
								<div slot="Acciones" slot-scope="props">
								<button class="btn btn-danger" data-toggle="tooltip" v-on:click="deleteActividad(props.row.ID)" data-placement="left" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button>
								<button class="btn btn-info" data-toggle="tooltip" v-on:click="editActividad(props.row.ID)" data-placement="left" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button>
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
			actividad:{
                oficina:null,
                objetivo:null,
                proceso:null,
                actividad:null,
			},
			actividades:[{
				ID:null,
				oficina:null,
				objetivo:null,
				proceso:null,
				actividad:null
            }],
            columns: ["oficina","objetivo","proceso","actividad","Acciones"],
            options: {
				headings:
				{
					oficina: "Oficina",
					objetivo: "Objetivo",
					proceso: "Proceso",
					actividad:"Actividad",
					Acciones: "Acciones",
					
				},
				sortable    : ["oficina","objetivo","proceso","actividad"],
				filterable  : ["oficina","objetivo","proceso","actividad"]
			},
			oficinas:[],
            objetivosL:[],
			procesosL:[],
			id:null
        }
	},
	created(){
		this.getDatos();
		this.getActividades();
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
        objetivos()
        {
			var id = this.actividad.oficina;
            axios.get(`getObjetivos/${id}`)
            .then(data=>
            {
                this.objetivosL = data.data.objetivos;
                console.log(this.objetivosL);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        zprocesos()
        {
			var id2 = this.actividad.objetivo;
			console.log(this.actividad.objetivo);
			axios.get(`getProcesos/${id2}`)
            .then(data=>
            {
                this.procesosL = data.data.procesos;
                console.log(this.procesosL);
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		getActividades()
        {
            axios.get(`getActividades`)
            .then(data=>
            {
                this.actividades = data.data.actividades;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
		RegistrarActividad()
		{
			axios.post("addActividad",{
				actividad:this.actividad
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
        deleteActividad(id)
        {
            swal({
                title: '¿Deseas eliminar esta Actividad?',
                text: "No será posible revertir esta acción!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, elíminalo!',
                cancelButtonText: 'No, cancelar!',
            }).then((result) => {
                if (result.value) {
                    axios.get(`/deleteActividad/${id}`)
                        .then(data => {
                        if(data.data=="OK"){
                            swal(
                            'Eliminado!',
                             'El Proceso ha sido eliminado.',
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
		editActividad(id)
		{
			this.id = id;
			$('#objetivo').show();
			$('#editar').show();
			$('#carga').hide();
			axios.get('getActividad/'+id)
            .then(data=>
            {
                this.actividad.actividad = data.data.actividad;
			 	console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		editar()
		{
			axios.get('updateActividad/' + this.id + '/' + this.actividad.actividad)
            .then(data=>
            {
				this.actividad.actividad = null;
				$('#objetivo').hide();
				$('#carga').show();	
				$('#editar').hide();	
				this.getActividades();
				console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		}
    }
}
</script>
