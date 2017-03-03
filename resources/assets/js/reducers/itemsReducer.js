import { fromJS, Map, List } from 'immutable';
import { Item } from '../objectDefinitions/Item';

import { 
	REQUEST_ITEMS,
	RECEIVE_ITEMS_SUCCESS,
	RECEIVE_ITEMS_FAILURE,
	DECREMENT_ITEM_REQUEST,
	DECREMENT_ITEM_SUCCESS,
	DECREMENT_ITEM_FAILURE,	
	INCREMENT_ITEM_REQUEST,
	INCREMENT_ITEM_SUCCESS,
	INCREMENT_ITEM_FAILURE,
} from '../actions/inventoryActions';

const initialState = new Map({
	data: Map(),
	loading: false,
});

export const items = (state = initialState, action) => {
	const currentQty = state.getIn(['data', action.itemId, 'quantity']);

	switch(action.type) {
		case RECEIVE_ITEMS_SUCCESS:
			return state
				.set('loading', false)
				.set('data', action.payload.get('data'));
				// .reduce(
			        // (lookup, item) => lookup.set(item.get('id'), new Item(item)),
			        // Map()
			    // ));

		case RECEIVE_ITEMS_FAILURE:
			return state;

		case REQUEST_ITEMS:
			return state.set('loading', true);

		case INCREMENT_ITEM_REQUEST:
			return state
				.set('loading', true)
				.setIn(['data', action.itemId, 'quantity'], currentQty + 1);

		case INCREMENT_ITEM_SUCCESS:
			return state.set('loading', false);

		case INCREMENT_ITEM_FAILURE:
			return state
				.set('loading', false)
				.setIn(['data', action.itemId, 'quantity'], currentQty - 1);

		case DECREMENT_ITEM_REQUEST:
			return state
				.set('loading', true)
				.setIn(['data', action.itemId, 'quantity'], currentQty - 1);

		case DECREMENT_ITEM_SUCCESS:
			return state.set('loading', false);

		case DECREMENT_ITEM_FAILURE:
			return state
				.set('loading', false)
				.setIn(['data', action.itemId, 'quantity'], currentQty + 1);

		default:
			return state;
	}
}
