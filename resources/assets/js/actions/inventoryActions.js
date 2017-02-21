export const SELECT_ITEM_CATEGORY = 'SELECT_ITEM_CATEGORY';
export const selectItemCategory = (categoryName) => {
	console.log('Category selected:'+categoryName);
	return {
		type: SELECT_ITEM_CATEGORY,
		categoryName,
	}
}

/*
 * Don't call requestItemCategories() directly - it's dispatched from within `fetchItemCategories()`
 */
export const REQUEST_ITEM_CATEGORIES = 'REQUEST_ITEM_CATEGORIES';
export const requestItemCategories = () => {
	return {
		type: REQUEST_ITEM_CATEGORIES,
	}
}

/*
 * Don't call receiveItemCategories() directly - it's dispatched from within `fetchItemCategories()`
 */
export const RECEIVE_ITEM_CATEGORIES = 'RECEIVE_ITEM_CATEGORIES';
export const receiveItemCategories = (categories) => {
	return function(dispatch) {
		for (let category of Object.values(categories)) {
			dispatch(receiveItemCategory(category.name, { category: category } ));
		}
	}
}

export const INVALIDATE_ITEM_CATEGORIES = 'INVALIDATE_ITEM_CATEGORIES';
export const invalidateItemCategories = () => {
	return {
		type: INVALIDATE_ITEM_CATEGORIES,
	}
}

export const fetchItemCategories = () => {
	// Requires the `redux-thunk` library for making asynchronous calls.
	return function(dispatch) {

		dispatch(requestItemCategories());

		return fetch(`/crew/1/inventory?format=json`, { credentials: "same-origin" })
			.then(response => response.json())
			.then(json => dispatch(receiveItemCategories(json.categories)) )
	}
}

/*
 * Don't call requestItemCategory() directly - it's dispatched from within `fetchItemCategory()`
 */
export const REQUEST_ITEM_CATEGORY = 'REQUEST_ITEM_CATEGORY';
export const requestItemCategory = (categoryName) => {
	return {
		type: REQUEST_ITEM_CATEGORY,
		categoryName,
	}
}

/*
 * Don't call receiveItemCategory() directly - it's dispatched from within `fetchItemCategory()`
 */
export const RECEIVE_ITEM_CATEGORY = 'RECEIVE_ITEM_CATEGORY';
export const receiveItemCategory = (categoryName, json) => {
	return {
		type: RECEIVE_ITEM_CATEGORY,
		categoryName,
		items: json.category.items,
		receivedAt: Date.now(),
	}
}

export const INVALIDATE_ITEM_CATEGORY = 'INVALIDATE_ITEM_CATEGORY';
export const invalidateItemCategory = (categoryName) => {
	return {
		type: INVALIDATE_ITEM_CATEGORY,
		categoryName
	}
}

export const fetchItemCategory = (categoryName) => {
	// Requires the `redux-thunk` library for making asynchronous calls.
	return function(dispatch) {

		dispatch(requestItemCategory(categoryName));

		return fetch(`/crew/1/inventory?format=json&category=${categoryName}`, { credentials: "same-origin" })
			.then(response => response.json())
			.then(json =>
				dispatch(receiveItemCategory(categoryName, json))
			)
	}
}
