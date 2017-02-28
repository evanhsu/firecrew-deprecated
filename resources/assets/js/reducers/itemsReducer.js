import { fromJS, Map, List } from 'immutable';
import { Item } from '../objectDefinitions/Item';

import { 
	REQUEST_ITEMS,
	RECEIVE_ITEMS_SUCCESS,
	RECEIVE_ITEMS_FAILURE,
	DECREMENT_ITEM_REQUEST,
	DECREMENT_ITEM_FAILURE,	
	INCREMENT_ITEM_REQUEST,
	INCREMENT_ITEM_FAILURE,
} from '../actions/inventoryActions';

const initialState = new Map({
	data: List(),
	loading: false,
});

export const items = (state = initialState, action) => {
	switch(action.type) {
		case RECEIVE_ITEMS_SUCCESS:
			return state
				.set('loading', false)
				.set('data', action.items.map(
					(item) => new Item(item) // Convert each item to an Immutable Record
				));

		case RECEIVE_ITEMS_FAILURE:
			return state;

		case REQUEST_ITEMS:
			return state.set('loading', true);

		default:
			return state;
	}
}
