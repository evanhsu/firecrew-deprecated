import { fromJS, Map, List } from 'immutable';

import { 
	REQUEST_ITEMS,
	RECEIVE_ITEMS_SUCCESS,
	RECEIVE_ITEMS_FAILURE,
} from '../actions/inventoryActions';

const initialState = new Map({
	data: List(),
	loading: false,
});

export const categories = (state = initialState, action) => {
	switch(action.type) {
		case RECEIVE_ITEMS_SUCCESS:
			return state
				.set('loading', false)
				.set('data', 
					action.items
					.map((item) => item.get('category'))
					.toSet()
					.toList()
					.sort()
				);

		case RECEIVE_ITEMS_FAILURE:
			return state;

		case REQUEST_ITEMS:
			return state.set('loading', true);

		default:
			return state;
	}
}
