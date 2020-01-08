<template>
    <div class="content">
	    <div class="container-fluid">
	    	<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<button  class="btn btn-outline-primary" @click="ocultar('1')">
						Caracterización <i class="fa fa-plus"></i>
						</button>
						<button  class="btn btn-outline-primary" @click="ocultar('2')">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			 <div class="col-md-12" id="objetivo">
	            <div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">Reporte final de Cumplimiento Trimestral por oficinas</h4>  
	                </div>
					<div class="card-body">
						<table class="table table-striped table-bordered table-hover text-center">
                            <tr style="background-color:gray;">
                                <td>Oficina/trimestre</td>
                                <td>Trimestre I</td>
                                <td>Trimestre II</td>
                                <td>Trimestre III</td>
                                <td>Trimestre IV</td>
                            </tr>
                            <tr>
                                <td>OPC</td>
                                <td>{{of1t1}}%</td>
                                <td>{{of1t2}}%</td>
                                <td>{{of1t3}}%</td>
                                <td>{{of1t4}}%</td>
                            </tr>
                            <tr>
                                <td>UIS</td>
                                <td>{{of4t1}}%</td>
                                <td>{{of4t2}}%</td>
                                <td>{{of4t3}}%</td>
                                <td>{{of4t4}}%</td>
                            </tr>
                            <tr>
                                <td>UPCyRM</td>
                                <td>{{of2t1}}%</td>
                                <td>{{of2t2}}%</td>
                                <td>{{of2t3}}%</td>
                                <td>{{of2t4}}%</td>
                            </tr>
                            <tr>
                                <td>UCAP</td>
                                <td>{{of3t1}}%</td>
                                <td>{{of3t2}}%</td>
                                <td>{{of3t3}}%</td>
                                <td>{{of3t4}}%</td>
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
			of1t1:null,
            of1t2:null,
            of1t3:null,
            of1t4:null,
            of2t1:null,
            of2t2:null,
            of2t3:null,
            of2t4:null,
            of3t1:null,
            of3t2:null,
            of3t3:null,
            of3t4:null,
            of4t1:null,
            of4t2:null,
            of4t3:null,
            of4t4:null,
        }
	},
	created(){
		this.getDatos();
	},
	mounted(){
		$('#objetivo').show();

	},
    methods: {
		getDatos()
        {
            axios.get("getMetas")
            .then(data=>
            {
                this.of1t1=(parseFloat(data.data.of1t1[0].percent)*100).toFixed(2);
                this.of1t2=(parseFloat(data.data.of1t2[0].percent)*100).toFixed(2);
                this.of1t3=(parseFloat(data.data.of1t3[0].percent)*100).toFixed(2);
                this.of1t4=(parseFloat(data.data.of1t4[0].percent)*100).toFixed(2);
                this.of2t1=(parseFloat(data.data.of2t1[0].percent)*100).toFixed(2);
                this.of2t2=(parseFloat(data.data.of2t2[0].percent)*100).toFixed(2);
                this.of2t3=(parseFloat(data.data.of2t3[0].percent)*100).toFixed(2);
                this.of2t4=(parseFloat(data.data.of2t4[0].percent)*100).toFixed(2);
                this.of3t1=(parseFloat(data.data.of3t1[0].percent)*100).toFixed(2);
                this.of3t2=(parseFloat(data.data.of3t2[0].percent)*100).toFixed(2);
                this.of3t3=(parseFloat(data.data.of3t3[0].percent)*100).toFixed(2);
                this.of3t4=(parseFloat(data.data.of3t4[0].percent)*100).toFixed(2);
                this.of4t1=(parseFloat(data.data.of4t1[0].percent)*100).toFixed(2);
                this.of4t2=(parseFloat(data.data.of4t2[0].percent)*100).toFixed(2);
                this.of4t3=(parseFloat(data.data.of4t3[0].percent)*100).toFixed(2);
                this.of4t4=(parseFloat(data.data.of4t4[0].percent)*100).toFixed(2);
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
			}
			else if(id == '2')
			{
				$('#objetivo').hide();	
			}
			
		},
       
    }
}
</script>
