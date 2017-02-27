import { fromJS, List } from 'immutable';
import { 
	REQUEST_ITEMS,
	RECEIVE_ITEMS_SUCCESS,
	RECEIVE_ITEMS_FAILURE,
	DECREMENT_ITEM_REQUEST,
	DECREMENT_ITEM_FAILURE,	
	INCREMENT_ITEM_REQUEST,
	INCREMENT_ITEM_FAILURE,
} from '../actions/inventoryActions';

const initialState = fromJS({
	items: [],
});

export const items = (state = initialState, action) => {
	switch(action.type) {
		case RECEIVE_ITEMS_SUCCESS:
			return state.set('items', action.items);

		case RECEIVE_ITEMS_FAILURE:
			return state;

		default:
			return state;
	}
}
