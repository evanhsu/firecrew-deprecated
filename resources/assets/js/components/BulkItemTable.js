import React, { Component, PropTypes } from 'react';
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';


const cellStyle = {
	padding: 5,
	height: 30,
	whiteSpace: 'normal',
};

const rowStyle = {
	height: 30,
};

const smColWidth = { width: 50 };
const mdColWidth = { width: 100 };
const lgColWidth = { width: 165 };

const smColStyle = Object.assign({}, cellStyle, smColWidth);
const mdColStyle = Object.assign({}, cellStyle, mdColWidth);
const lgColStyle = Object.assign({}, cellStyle, lgColWidth);

const ItemRow = ({item}) => (
	<TableRow style={rowStyle} hoverable>
        <TableRowColumn style={smColStyle}>{item.quantity}</TableRowColumn>
        <TableRowColumn style={lgColStyle}>{item.description}</TableRowColumn>	
        <TableRowColumn style={smColStyle}>{item.size}</TableRowColumn>	
        <TableRowColumn style={smColStyle}>{item.color}</TableRowColumn>	
        <TableRowColumn style={smColStyle}>{item.restock_trigger}</TableRowColumn>	
        <TableRowColumn style={smColStyle}>{item.restock_to_quantity}</TableRowColumn>	
        <TableRowColumn style={lgColStyle}>{item.note}</TableRowColumn>	
        <TableRowColumn style={mdColStyle}>{item.source}</TableRowColumn>	
        <TableRowColumn style={mdColStyle}>{item.updated_at}</TableRowColumn>	
    </TableRow>
);

class BulkItemTable extends Component {
	render() {
		if(this.props.items.length == 0) {
			return null;
		} else {
			return (
				<Table>
			    	<TableHeader displaySelectAll={false} adjustForCheckbox={false}>
						<TableRow>
							<TableHeaderColumn style={smColStyle}>Qty</TableHeaderColumn>
							<TableHeaderColumn style={lgColStyle}>Description</TableHeaderColumn>
							<TableHeaderColumn style={smColStyle}>Size</TableHeaderColumn>
							<TableHeaderColumn style={smColStyle}>Color</TableHeaderColumn>
							<TableHeaderColumn style={smColStyle}>Min Qty</TableHeaderColumn>
							<TableHeaderColumn style={smColStyle}>Restock To</TableHeaderColumn>
							<TableHeaderColumn style={lgColStyle}>Note</TableHeaderColumn>
							<TableHeaderColumn style={mdColStyle}>Source</TableHeaderColumn>
							<TableHeaderColumn style={mdColStyle}>Updated</TableHeaderColumn>
						</TableRow>
					</TableHeader>
					<TableBody displayRowCheckbox={false} showRowHover preScanRows={false}>
						{this.props.items && this.props.items.map((item) => (
							<ItemRow key={item.id} item={item} />
						))}
					</TableBody>
			    </Table>
			);
		}
	};
}

BulkItemTable.PropTypes = {
	items: PropTypes.array,
};

export default BulkItemTable;