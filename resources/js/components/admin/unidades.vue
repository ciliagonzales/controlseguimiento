<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<button  class="btn btn-outline-primary" @click="ocultar('1')">
						Oficina <i class="fa fa-plus"></i>
						</button>
						<button  class="btn btn-outline-primary" @click="ocultar('3')">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<button  class="btn btn-outline-primary" @click="ocultar('2')">
						Encargado <i class="fa fa-plus"></i>
						</button>
						<button  class="btn btn-outline-primary" @click="ocultar('4')">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			 <div class="col-md-12" id="agregar">
	            <div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">OFICINAS</h4>  
	                </div>
	                <div class="card-body" >
	                    <form @submit.prevent="registrar" method="POST" id="register">
	                        <div class="row" >
	                            <div class="col-md-4">
	                                <div class="form-group">
	                                    <label>Nombre de Oficina 
											
										</label>
	                                    <input type="text" v-model="oficina.nombre" class="form-control"   maxlength="100">
								    </div>
	                            </div>
							</div>
							<div class="row text-left">
								<div class="col-md-2">
									<input type="submit" value="Agregar" class="btn btn-success">
								</div>
							</div>
							<!-- <div class="clearfix"></div> -->
	                    </form>
	                </div>
					<div class="card-body">
	                    <form @submit.prevent="RegistrarEncargado" method="POST"  id="encargado">
	                        <div class="row">
	                            <div class="col-md-4">
	                                <div class="form-group">
	                                    <label>Encargado</label>
	                                    <input type="text" v-model="encargado.nombre" class="form-control"   maxlength="100">
	                                </div>
	                            </div>
								<div class="col-md-4">
	                                <div class="form-group">
	                                    <label>Usuario</label>
	                                    <input type="text" v-model="encargado.user" class="form-control" maxlength="20">
	                                </div>
	                            </div>
								<div class="col-md-4">
	                                <div class="form-group">
	                                    <label>Oficina</label>
										<select v-model="encargado.oficina" class="form-control">
											<option v-for="o in oficinas" :key="o.IDOficina" :value="o.IDOficina">
												{{o.NombreOficina}}		
											</option>
										</select>
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
	                                    <label>Encargado</label>
	                                    <input type="text" v-model="encargado.nombre" class="form-control"   maxlength="100">
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
	                <div class="card-header text-center">
	                    <h4 class="title">Lista de Oficinas</h4>  
	                </div>
	                <div class="card-body">
						<div class="content table-responsive table-full-width">
                            <v-client-table :data="oficinasE" :columns="columns" :options="options">
								<div slot="Acciones" slot-scope="props">
								<button class="btn btn-info" data-toggle="tooltip" v-on:click="editEncargado(props.row.ID)" data-placement="left" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button>
								<button class="btn btn-danger" data-toggle="tooltip" v-on:click="deleteEncargado(props.row.ID)" data-placement="left" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
			encargado:{
				nombre:null,
				oficina:null,
				user:null,
			},
            oficina: {
                nombre:null,
            },
			oficinasE:[{
				ID:null,
				oficina:null,
                encargado:null,
            }],
            columns: ["oficina","encargado","Acciones"],
            options: {
				headings:
				{
					oficina: "Oficina",
					encargado: "Encargado",
					Acciones: "Acciones",
					
				},
				sortable: ["Oficinas","Encargado"],
				filterable: ["Oficinas","Encargado"]
			},
			oficinas:[],
			id:null

        }
	},
	created(){
		this.getDatos();
		this.getEncargados();
	},
	mounted(){
		$('#agregar').hide();
		$('#encargado').hide();
		$('#register').hide();
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
		getEncargados()
        {
            axios.get("getEncargados")
            .then(data=>
            {
                this.oficinasE = data.data.oficinas;
                console.log(this.oficinasE);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        registrar()
		{
			axios.post("addOficina",{
				oficina:this.oficina
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
		RegistrarEncargado()
		{
			axios.post("addEncargado",{
				encargado:this.encargado
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
				$('#agregar').show();
				$('#register').show();
				$('#encargado').hide();
			}
			else if(id == '2')
			{
				$('#agregar').show();
				$('#encargado').show();
				$('#register').hide();	
			}
			else if(id == '3')
			{
				$('#agregar').hide();
				$('#register').hide();
			}
			else if(id == '4')
			{
				$('#agregar').hide();
				$('#encargado').hide();	
			}
		},
		deleteEncargado(id){
            swal({
                title: '¿Deseas eliminar este Encargado?',
                text: "No será posible revertir esta acción!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, elíminalo!',
                cancelButtonText: 'No, cancelar!',
            }).then((result) => {
                if (result.value) {
                    axios.get(`/eliminarEncargado/${id}`)
                        .then(data => {
                        if(data.data=="OK"){
                            swal(
                            'Eliminado!',
                             'El Encargado ha sido eliminado.',
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
		editEncargado(id)
		{
			this.id = id;
			$('#agregar').show();
			$('#editar').show();
			axios.get("getEncargado/" + id)
            .then(data=>
            {
                this.encargado.nombre = data.data.nombre;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		editar()
		{
			$('#agregar').hide();
			$('#encargado').hide();
			$('#register').hide();
			$('#editar').hide();
			axios.get("updateEncargado/" + this.id + "/" + this.encargado.nombre)
            .then(data=>
            {
				this.encargado.nombre = null;
				this.getEncargados();
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		}
    }
}
</script>
