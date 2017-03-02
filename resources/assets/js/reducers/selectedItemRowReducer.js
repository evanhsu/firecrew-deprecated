import React from 'react';
import { 
	ITEM_ROW_SELECTED,
	ITEM_ROW_DESELECTED,
} from '../actions/inventoryActions';

const initialState = null;

export function selectedItemRow(state = initialState, action) {
	switch(action.type) {
		case ITEM_ROW_SELECTED:
			return action.itemId;
		case ITEM_ROW_DESELECTED:
			return null;
		default:
			return state;
	}
}
