<template>
    <div class="content">
	    <div class="container-fluid">
			<div class="row">
			 <div class="col-md-12">
				<div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">Descargas de entregables</h4>  
	                </div>
	                <div class="card-body">
						<div class="content table-responsive table-full-width" style="font-size: 11px">
                            <v-client-table :data="entregables" :columns="columns" :options="options">
								<div slot="Acciones" slot-scope="props">
								<button class="btn btn-success" data-toggle="tooltip" v-on:click="download(props.row.archivo)" data-placement="left" title="Descargar"><i class="fa fa-download" aria-hidden="true"></i></button>
                                <button class="btn btn-primary" data-toggle="tooltip" v-on:click="editarAvance(props.row.ID)" data-placement="left" title="Editar"><i class="fa fa-edit" aria-hidden="true"></i></button>
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
			entregables:[{
				ID:null,
				oficina:null,
				objetivo:null,
                proceso:null,
                actividad:null,
                subactividad:null,
                trimestre:null,
                monto:null,
                archivo:null,
                nombreArchivo:null,     
                fecha:null,
            }],
            columns: ["oficina","objetivo","proceso","actividad","subactividad","trimestre","monto","nombreArchivo","fecha","Acciones"],
            options: {
				headings:
				{
					oficina: "Oficina",
					objetivo: "Objetivo",
                    proceso: "Proceso",
                    actividad:"Actividad",
                    subactividad:"Subactividad",
                    nombreArchivo:"Archivo",
                    trimestre:"Trimestre",
                    monto:"Cantidad Avanzada",
                    fecha:"Fecha",
					Acciones: "Acciones",
					
				},
				sortable    : ["oficina","objetivo","proceso","actividad","nombreArchivo","subactividad","fecha"],
				filterable  : ["oficina","objetivo","proceso","actividad","nombreArchivo","subactividad","fecha"],
			},
			
        }
	},
	created(){
		this.getEntregables();
	},
	mounted(){
	},
    methods: {
		getEntregables()
        {
            axios.get(`getEntregable`)
            .then(data=>
            {
                this.entregables = data.data.entregables;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        download(id)
        {
            var url    = "archivos/" + id;    
            window.open(url, 'Download');
        },
        editarAvance(id)
		{
			this.$Progress.start();
            swal({
                title: 'Editar cantidad de avance',
				// type: 'warning',
				// text: 'Ingrese motivo de rechazo',
				input: 'text',
				inputAttributes: {
					autocapitalize: 'off'
				},
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
				confirmButtonText: 'Si',
				cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    axios.get(`/editarAvance/${id}/${result.value}`)
                        .then(data => {
						this.$Progress.finish();
						if(data.data=="OK"){
                            swal(
                            // 'Actualizado!',
                             'Actualizado con éxito.',
                             'success'
                                );
                            // setTimeout(() => {
                            //     location.reload();
                            // }, 1500);
                            this.getEntregables();
                        }
                        }).catch(error => {
                            console.log('Ocurrio un error ' + error);
                            this.$Progress.fail();
                        });
                     }
                });
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
