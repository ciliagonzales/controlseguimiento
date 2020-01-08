<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
                <div class="col-md-6">
					<div class="form-group">
						<button  class="btn btn-outline-primary" @click="ocultar('2')">
						PLAN ANUAL <i class="fa fa-plus"></i>
						</button>
						<button  class="btn btn-outline-primary" @click="ocultar('1')">
						EJECUCION	<i class="fa fa-plus"></i>
						</button>
					</div>
				</div>
			 <div class="col-md-12" id="objetivo">
	            <div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">AVANCE DE EJECUCIÓN</h4>  
	                </div>
					<div class="card-body">
						<table class="table table-striped table-bordered table-hover text-center">
                            <tr style="background-color:gray;">
                                <td>Oficina</td>
                                <td>Subactividad</td>
                                <td>Trimestre I</td>
                                <td>Trimestre II</td>
                                <td>Trimestre III</td>
                                <td>Trimestre IV</td>
                            </tr>
                            <tr v-for="e in ejecucion" :key="e.ID">
                                <td>{{e.NombreOficina}}</td>
                                <td>{{e.SubActividad}}</td>
                                <td>{{e.monto1}}</td>
                                <td>{{e.monto2}}</td>
                                <td>{{e.monto3}}</td>
                                <td>{{e.monto4}}</td>
                            </tr>
                        </table>
	                </div>
				</div>
			    </div>
                <div class="col-md-12" id="ejecucion">
	            <div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">PROGRAMACIÓN ANUAL</h4>  
	                </div>
					<div class="card-body">
						<table class="table table-striped table-bordered table-hover text-center">
                            <tr style="background-color:gray;">
                                <td>Oficina</td>
                                <td>Subactividad</td>
                                <td>Trimestre I</td>
                                <td>Trimestre II</td>
                                <td>Trimestre III</td>
                                <td>Trimestre IV</td>
                            </tr>
                            <tr v-for="e in anual" :key="e.ID">
                                <td>{{e.NombreOficina}}</td>
                                <td>{{e.SubActividad}}</td>
                                <td>{{e.Trimestre1}}</td>
                                <td>{{e.Trimestre2}}</td>
                                <td>{{e.Trimestre3}}</td>
                                <td>{{e.Trimestre4}}</td>
                            </tr>
                        </table>
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
			ejecucion:[],
            anual:[],
        }
	},
	created(){
		this.getDatos();
	},
	mounted(){
		$('#objetivo').hide();
        $('#ejecucion').show();
	},
    methods: {
		getDatos()
        {
            this.$Progress.start();
            axios.get("getEjecucion")
            .then(data=>
            {
                this.$Progress.finish();
                this.ejecucion  = data.data.avances;
                this.anual      = data.data.anual;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
		ocultar(id){
			if(id == '1')
			{
				$('#objetivo').show();
                $('#ejecucion').hide();
			}
			else if(id == '2')
			{
				$('#objetivo').hide();
                $('#ejecucion').show();	
			}
			
		},
       
    }
}
</script>
