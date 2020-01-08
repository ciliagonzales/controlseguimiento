<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
			 <div class="col-md-12">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<button  class="btn btn-outline-primary" @click="ocultar('1')">
							PROCESOS <i class="fa fa-plus"></i>
							</button>
							<button  class="btn btn-outline-primary" @click="ocultar('2')">
								<i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
				</div>
	            <div class="card card-default" id="objetivo">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">PROCESOS ESTRATÉGICOS</h4>  
	                </div>
					<div class="card-body" >
	                    <form @submit.prevent="RegistrarProceso" method="POST" id="carga">
	                        <div class="row">
	                            <div class="col-md-4">
	                                <div class="form-group">
	                                    <label>Oficina</label>
										<select v-model="procesoz.oficina" class="form-control" @change="objetivos()">
											<option v-for="o in oficinas" :key="o.IDOficina" :value="o.IDOficina" >
												{{o.NombreOficina}}		
											</option>
										</select>
	                                </div>
	                            </div>
                                <div class="col-md-4">
	                                <div class="form-group">
	                                    <label>Objetivo</label>
										<select v-model="procesoz.objetivo" class="form-control">
											<option v-for="o in objetivosL" :key="o.ID" :value="o.ID">
												{{o.Descripcion}}		
											</option>
										</select>
	                                </div>
	                            </div>
                                <div class="col-md-4">
	                                <div class="form-group">
	                                    <label>Procesos Estratégico</label>
	                                    <input type="text" v-model="procesoz.zproceso" class="form-control"   maxlength="100">
	                                </div>
	                            </div>
							</div>
							<div class="row text-left">
								<div class="col-md-2">
									<input type="submit" value="Registrar" class="btn btn-success">
								</div>
							</div>
	                    </form>
							<div class="col-md-12" id="editar">
								<div class="row">
									<div class="col-md-10">
										<div class="form-group">
											<label>Procesos Estratégico</label>
											<input type="text" v-model="procesoz.zproceso" class="form-control"   maxlength="100">
										</div>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<button class="btn btn-outline-success" @click="editar()">
										Guardar Cambios
										</button>	
									</div>
								</div>
							</div>
						<div class="clearfix"></div>
	                </div>
				</div>
			</div>
	    	</div>
			<div class="row">
			 <div class="col-md-12">
				<div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">OFICINAS VS PROCESOS ESTRATÉGICOS</h4>  
	                </div>
	                <div class="card-body">
						<div class="content table-responsive table-full-width">
                            <v-client-table :data="procesos" :columns="columns" :options="options">
								<div slot="Acciones" slot-scope="props">
								<button class="btn btn-danger" data-toggle="tooltip" v-on:click="deleteProceso(props.row.ID)" data-placement="left" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button>
								<button class="btn btn-info" data-toggle="tooltip" v-on:click="editProceso(props.row.ID)" data-placement="left" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button>
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
			procesoz:{
                oficina:null,
                objetivo:null,
				zproceso:null,
			},
			procesos:[{
				ID:null,
				oficina:null,
				objetivo:null,
				proceso:null
            }],
            columns: ["oficina","objetivo","proceso","Acciones"],
            options: {
				headings:
				{
					oficina: "Oficina",
					objetivo: "Objetivo",
					proceso: "Proceso",
					Acciones: "Acciones",
					
				},
				sortable    : ["oficina","objetivo"],
				filterable  : ["oficina","objetivo"]
			},
			oficinas:[],
			objetivosL:[],
			id : null,
        }
	},
	created(){
		this.getDatos();
		this.getProcesos();
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
			var id = this.procesoz.oficina;
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
		getProcesos()
        {
            axios.get(`getProcesos`)
            .then(data=>
            {
                this.procesos = data.data.procesos;
                console.log(this.procesos);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
		RegistrarProceso()
		{
			axios.post("addProceso",{
				procesoz:this.procesoz
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
        deleteProceso(id)
        {
            swal({
                title: '¿Deseas eliminar este Proceso?',
                text: "No será posible revertir esta acción!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, elíminalo!',
                cancelButtonText: 'No, cancelar!',
            }).then((result) => {
                if (result.value) {
                    axios.get(`/deleteProceso/${id}`)
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
		editProceso(id)
		{
			axios.get('getProceso/'+id)
            .then(data=>
            {
				$('#objetivo').show();
				$('#carga').hide();
				$('#editar').show();
				// this.procesos = data.data.procesos;
				this.id = id;
				this.procesoz.zproceso = data.data.procesos[0].Descripcion;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		editar(){
			axios.get('editProceso/'+this.id+'/'+this.procesoz.zproceso)
            .then(data=>
            {
				$('#objetivo').hide();
				$('#carga').show();
				$('#editar').hide();
				this.procesoz.zproceso = null;
				this.getProcesos();
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		}
    }
}
</script>
