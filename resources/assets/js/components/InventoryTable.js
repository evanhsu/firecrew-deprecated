import React, { Component } from 'react';
import {Table, TableBody, TableHeader, TableHeaderColumn, TableRow, TableRowColumn} from 'material-ui/Table';

const InventoryTable = (props) => (
	<Table>
    	<TableHeader displaySelectAll={false} adjustForCheckbox={false}>
			<TableRow>
				<TableHeaderColumn>ID</TableHeaderColumn>
				<TableHeaderColumn>Serial #</TableHeaderColumn>
				<TableHeaderColumn>Category</TableHeaderColumn>
				<TableHeaderColumn>Description</TableHeaderColumn>
			</TableRow>
		</TableHeader>
		<TableBody displayRowCheckbox={false} showRowHover preScanRows={false}>
			{props.items.map((item) => (
				<TableRow key={item.id} hoverable>
					<TableRowColumn>{item.id}</TableRowColumn>
			        <TableRowColumn>{item.serialNumber}</TableRowColumn>
			        <TableRowColumn>{item.category}</TableRowColumn>	
			        <TableRowColumn>{item.description}</TableRowColumn>	
			    </TableRow>
			))}
		</TableBody>
    </Table>
);

export default InventoryTable;