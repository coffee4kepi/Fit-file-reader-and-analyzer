//    Fit file reader and analyzer: disegna_func.js
//    Copyright (C) 2014  Ugolotti Aldo coffee4kepi@gmail.com
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.

function disegna(div_graph,sizew,sizeh,render,colore,dato,nomedato,div_x,yformat,div_y){

	var graph = new Rickshaw.Graph( {
			element: document.querySelector(div_graph),
			width: sizew,
			height: sizeh,
			renderer: render,
			series: [{
				color: colore,
				data: dato,
				name: nomedato
			}],
			min: 'auto',
			padding: {top: 0.1, left: 0.1, right: 0.1, bottom: 0.1}
		} );

		var x_axis = new Rickshaw.Graph.Axis.X( {
			graph: graph,
			orientation: 'bottom',
			element: document.getElementById(div_x)
		} );

		var y_axis = new Rickshaw.Graph.Axis.Y( {
			graph: graph,
			orientation: 'left',
			ticks: 10,
			tickFormat: yformat,		//custom label dei dati visualizzati in y
			element: document.getElementById(div_y)
		} );


		var detail = new Rickshaw.Graph.HoverDetail({
			graph: graph,
			xFormatter: function(x){ return x;}
		});

		graph.render();
}
