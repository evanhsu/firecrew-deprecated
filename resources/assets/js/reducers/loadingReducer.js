import { 
	REQUEST_ITEMS,
	RECEIVE_ITEMS_SUCCESS,
	RECEIVE_ITEMS_FAILURE,
} from '../actions/inventoryActions';

const initialState = false;

export const loading = (state = initialState, action) => {
	switch(action.type) {
		case REQUEST_ITEMS:
			return true;

		case RECEIVE_ITEMS_SUCCESS:
		case RECEIVE_ITEMS_FAILURE:
			return false;

		default:
			return state;
	}
}
