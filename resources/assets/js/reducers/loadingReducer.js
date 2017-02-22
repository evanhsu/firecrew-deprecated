import { 
	REQUEST_ITEM_CATEGORY,
	RECEIVE_ITEM_CATEGORY,
	REQUEST_ITEM_CATEGORIES,
	RECEIVE_ITEM_CATEGORIES,
} from '../actions/inventoryActions';

export function loading(state = {}, action) {
	switch(action.type) {
		case REQUEST_ITEM_CATEGORIES:
		case REQUEST_ITEM_CATEGORY:
			return true;

		case RECEIVE_ITEM_CATEGORIES:
		case RECEIVE_ITEM_CATEGORY:
			return false;

		default:
			return state;
	}
}