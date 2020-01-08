<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
			 <div class="col-md-12">
	            
	            <div class="card card-default">
	                <div class="card-header text-center">
	                    <h4 class="title">Agregar Cliente</h4>  
	                </div>
	                <div class="card-body">
	                    <form @submit.prevent="registrar" method="POST">
	                        <div class="row">
	                            <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Tipo de Documento(*)</label>
	                                    <select class="form-control" v-model="cliente.TipoDocumento">
											<option value="1">DNI</option>
											<option value="2">Pasaporte</option>
											<option value="3">Carnet de Extranjería</option>
										</select>
	                                </div>
	                            </div>
								<div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Documento(*)</label>
	                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' 
										v-model="cliente.DocCliente" class="form-control"   maxlength="11">
	                                </div>
	                            </div>
								<div class="col-md-6">
	                                <div class="form-group">
	                                    <label>Nombre y Apellidos(*)</label>
	                                    <input type="text" v-model="cliente.NomCliente" class="form-control"  maxlength="100">
	                                </div>
	                            </div>
							</div>
							<div class="row">
	                            <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Celular(*)</label>
	                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
										v-model="cliente.CelCliente" class="form-control"   maxlength="10">
	                                </div>
	                            </div>
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Telefono</label>
	                                    <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
										v-model="cliente.TelCliente" class="form-control"   maxlength="10">
	                                </div>
	                            </div>
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>E-mail</label>
	                                    <input type="email" v-model="cliente.EmailCliente" class="form-control"  maxlength="30">
	                                </div>
	                            </div>
								<div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Fecha de Nacimiento(*)</label>
	                                    <input type="date"  
										v-model="cliente.FecCliente" class="form-control" max="2018-12-31">
	                                </div>
	                            </div>
							</div>
							<div class="row">
								<div class="col-md-7">
									<div class="form-group">
										<label >Dirección(*)</label>
										<input type="text" v-model="cliente.DirCliente" class="form-control" maxlength="30">
									</div>
								</div>
							</div>
							<div class="row text-left">
								<div class="col-md-2">
									<input type="submit" value="Agregar" class="btn btn-success">
								</div>
							</div>
							<div class="clearfix"></div>
	                    </form>
	                </div>
				</div>
			</div>
	    	</div>
			<div class="row">
			 <div class="col-md-12">
				<div class="card card-default">
	                <div class="card-header text-center">
	                    <h4 class="title">Lista de Clientes</h4>  
	                </div>
	                <div class="card-body">
						<div class="content table-responsive table-full-width">
                            <v-client-table :data="clientes" :columns="columns" :options="options">
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
            cliente: {
				DocCliente:null,
				TipoDocumento:null,
				NomCliente:null,
				FecCliente:null,
				CelCliente:null,
				TelCliente:null,
				EmailCliente:null,
				DirCliente:null
			},
			clientes:[{
				descripcion:null,
                DocCliente:null,
                NomCliente:null,
				CelCliente:null,
				EmailCliente:null,
				DirCliente:null,
				fecha:null
            }],
            columns: ["descripcion","DocCliente","NomCliente","CelCliente","EmailCliente","DirCliente","fecha"],
            options: {
				headings:
				{
					descripcion: "Tipo",
					DocCliente: "Documento",
					NomCliente: "Nombre y Apellidos",
					CelCliente: "Celular",
					EmailCliente: "Correo",
					DirCliente: "Dirección",
					fecha:"fecha"
				},
				sortable: ["DocCliente","NomCliente","CelCliente","EmailCliente","DirCliente"],
				filterable: ["DocCliente","NomCliente","CelCliente","EmailCliente","DirCliente"]
			},

        }
	},
	created(){
        this.getDatos();
    },
    methods: {
		getDatos()
        {
            axios.get("getClientes")
            .then(data=>
            {
                this.clientes = data.data.clientes;
                console.log(this.clientes);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        registrar()
		{
			axios.post("addCliente",{
				cliente:this.cliente
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
		}
    }
}

</script>
