import { List } from 'immutable';
import { 
	SELECT_ITEM_CATEGORY,
	TOGGLE_CATEGORY_MENU_DRAWER,
} from '../actions/inventoryActions';

const initialState = null;
export function selectedItemCategory(state = initialState, action) {
	switch(action.type) {
		case SELECT_ITEM_CATEGORY:
			return action.categoryName;
		default:
			return state;
	}
}

export function categoryMenuDrawerOpen(state = false, action) {
	switch(action.type) {
		case TOGGLE_CATEGORY_MENU_DRAWER:
			return !state;
		case SELECT_ITEM_CATEGORY:
			return false;
		default:
			return state;
	}
}
