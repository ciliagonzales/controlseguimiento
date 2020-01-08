<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row" id="admin">
			 <div class="col-md-12">
				 <button class="btn btn-success" @click="avanceAnual(2)">Cumplimiento Trimestral por Oficina</button>
				 <button class="btn btn-success" @click="avanceAnual(1)">Avance anual/Trimestral</button>
	            <div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">Avances</h4>  
	                </div>
					<div class="card-body">
						<div id="ch">
							<div class="row" >
							<div class="col-md-6">
								<div class="form-group">
									<label>Oficina</label>
									<select class="form-control" v-model="avance.oficina">
										<option v-for="o in oficinas" :key="o.IDOficina" :value="o.IDOficina" >
											{{o.NombreOficina}}		
										</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Trimestre/Acumulado</label>
									<select class="form-control" v-model="avance.trimestre" @change="Avances()">
										<option value="1">I</option>
										<option value="2">II</option>
										<option value="3">III</option>
										<option value="4">IV</option>
									</select>
								</div>
							</div>
						</div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1" id="table1">
									<table class="table table-bordered table-striped text-center" style="font-size: 10px">
										<tr style="background-color: gray; color: white">
											<td>Oficina</td>
											<td>Objetivo</td>
											<td>Proceso</td>
											<td>Actividad</td>
											<td>Sub Actividad</td>
											<td>Unidad de Medida</td>
											<td>Programacion Anual</td>										
											<td>Ejecutado</td>											
											<td>Porcentaje % Anual Esperado</td>
											<td>Porcentaje % de Cumplimiento Trimestral</td>
											<td>Porcentaje % de Avance Anual</td>
										</tr>
										<tr v-for="a in avances" :key="a.id">
											<td>{{a.NombreOficina}}</td>
											<td>{{a.objetivos}}</td>
											<td>{{a.proceso}}</td>
											<td>{{a.actividad}}</td>
											<td>{{a.SubActividad}}</td>
											<td>{{a.unidad}}</td>
											<td>{{a.Meta}}</td>
											
											<td>{{a.monto}}</td>										
											<td>{{a.esperado}}%</td>
											<td v-if="a.percent < 70" style="background-color: red; color: white">{{a.percent}}%</td>
											<td v-if="a.percent >= 70 && a.percent < 85" style="background-color: yellow; color: black">{{a.percent}}%</td>
											<td v-if="a.percent >= 85" style="background-color: green; color: white">{{a.percent}}%</td>
											<td v-if="a.anual < 70" style="background-color: red; color: white">{{a.anual}}%</td>
											<td v-if="a.anual >= 70 && a.anual < 85" style="background-color: yellow; color: black">{{a.anual}}%</td>
											<td v-if="a.anual >= 85" style="background-color: green; color: white">{{a.anual}}%</td>
										</tr>
										<tr style="background-color: gray; color: white">
											<td colspan="5"></td>
											<td class="text-right">Total</td>
											<td class="text-right">{{total}}</td>
											<td class="text-right">{{monto}}</td>
											
											<td colspan="3"></td>
										</tr>
									</table>
								</div>
								<div class="col-md-10 col-md-offset-1" id="error1">
									<table class="table table-bordered table-striped text-center">
										<tr style="background-color: gray; color: white">
											<td>Oficina aun no sube avances para dicho periodo</td>
										</tr>
									</table>
								</div>
							</div>
							<Chart />
						</div>
						<div class="row" id="chart">
							<div class="col-md-6">
								<div class="form-group">
									<label>Oficina</label>
									<select class="form-control" v-model="avance.oficina">
										<option v-for="o in oficinas" :key="o.IDOficina" :value="o.IDOficina" >
											{{o.NombreOficina}}		
										</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Trimestre</label>
									<select class="form-control" v-model="avance.trimestre" @change="getAvances()">
										<option value="1">I</option>
										<option value="2">II</option>
										<option value="3">III</option>
										<option value="4">IV</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-10 col-md-offset-1" id="table">
								<table class="table table-bordered table-striped text-center" style="font-size: 10px">
									<tr style="background-color: gray; color: white">
										<td>Oficina</td>
										<td>Objetivo</td>
										<td>Proceso</td>
										<td>Actividad</td>
										<td>Sub Actividad</td>
										<td>Unidad de Medida</td>
										<td>Programacion Anual</td>										
										<td>Programacion Trimestral</td>	
										<td>Ejecutado</td>																												
										<td>Porcentaje % de Cumplimiento Trimestral</td>
									</tr>
									<tr v-for="a in avances" :key="a.id">
										<td>{{a.NombreOficina}}</td>
										<td>{{a.objetivos}}</td>
										<td>{{a.proceso}}</td>
										<td>{{a.actividad}}</td>
										<td>{{a.SubActividad}}</td>
										<td>{{a.unidad}}</td>
										<td>{{a.Meta}}</td>																
										<td>{{a.trimestral}}</td>	
										<td>{{a.monto}}</td>								
																				
										<td v-if="a.percent < 70" style="background-color: red; color: white">{{a.percent}}%</td>
										<td v-if="a.percent >= 70 && a.percent < 85" style="background-color: yellow; color: black">{{a.percent}}%</td>
										<td v-if="a.percent >= 85" style="background-color: green; color: white">{{a.percent}}%</td>
									</tr>
									<tr style="background-color: gray; color: white">
										<td colspan="5"></td>
										<td class="text-right">Total</td>
										<td class="text-right">{{total}}</td>
										<td class="text-right">{{totaltri}}</td>
										<td class="text-right">{{monto}}</td>
										
										<td></td>
									</tr>
								</table>
							</div>
							<div class="col-md-10 col-md-offset-1" id="error">
								<table class="table table-bordered table-striped text-center">
									<tr style="background-color: gray; color: white">
										<td>Oficina aun no sube avances para dicho periodo</td>
									</tr>
								</table>
							</div>
						</div>
					
						<div id="graph">
							<apexchart width="500" type="donut" :options="options" :series="series"></apexchart>
						</div>						
					</div>
				</div>
			 </div>
	    	</div>
			
		</div>
		
    </div>	
</template>
<script>
import Chart from './components/Chart.component.vue'
    export default {
		name: 'app',
		components: {
			Chart
		},
    data() {
        return {
			avance:{
				oficina 	: null,
				trimestre 	: null,
			},
			oficinas	: [],
			avances		: [],
			options: {
				
				labels: ['Alcanzado', 'Restante']
			},
			series: [
			],
			monto : 0,
			total : 0,
			totaltri : 0,
        }
	},
	created(){
		this.getDatos();
		
	},
	mounted(){
		$('#table').hide();
		$('#table1').hide();
		$('#error').hide();
		$('#error1').hide();
		$('#ch').hide();
		// $('#admin').hide();
        // $('#oficina').hide();
        this.getTipo();
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
		getTipo()
        {
            axios.get("getTipo")
            .then(data=>
            {
                console.log(data.data);
                // this.user.user = data.data.user;
                // this.user.pass = data.data.pass;
                // if(data.data.tipo == 1)
                // {
                //     $("#admin").show();
                //     $("#oficina").hide();
                // }else{
                //     $("#admin").hide();
                //     $("#oficina").show();
                // }
            }
            ).catch(error=>{
                console.log(error);
            })
        },
		getAvances()
        {
			this.monto = 0;
			this.total = 0;
			this.totaltri = 0;
			var o = this.avance.oficina;
			var t = this.avance.trimestre;
            axios.get("getAvances/"+o+"/"+t)
            .then(data=>
            {
				this.avances = data.data.metasTrimestrales;
				this.avances.forEach(element=>{
					this.monto += parseInt(element.monto);
					this.total += parseInt(element.Meta);
					this.totaltri += parseInt(element.trimestral);
				});
				this.series = data.data.var;
				if(this.avances != null)
				{
					$('#table').show();
					$('#error').hide();
					$('#graph').show();
				}
				else{
					$('#table').hide();
					$('#error').show();
					$('#graph').hide();
				}
				console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		Avances()
        {
			this.monto = 0;
			this.total = 0;
			var o = this.avance.oficina;
			var t = this.avance.trimestre;
            axios.get("avances/"+o+"/"+t)
            .then(data=>
            {
				this.avances = data.data.metasTrimestrales;
				this.avances.forEach(element=>{
					this.monto += parseInt(element.monto);
					this.total += parseInt(element.Meta);
				});
				if(this.avances != null)
				{
					$('#table1').show();
					$('#error1').hide();
					$('#graph').hide();
				}
				else{
					$('#table1').hide();
					$('#error2').show();
					$('#graph').hide();
				}
				console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		avanceAnual(id)
		{
			if(id == 1)
			{
				$('#chart').hide();
				$('#ch').show();
				$('#table').hide();
				$('#graph').hide();
			}else if(id == 2){
				$('#chart').show();
				$('#ch').hide();
			}
		},
       
    }
}
</script>
