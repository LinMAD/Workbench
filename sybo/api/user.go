package api

import (
	"encoding/json"
	"fmt"
	"github.com/LinMAD/workshops/sybo/generator"
	"net/http"
)

// TODO refactor to fetch all stored users form storage by method instead of by key
const usersKey = "all_users"

type (
	// UserCollection all registered users
	UserCollection struct {
		List []User `json:"users"`
	}

	// User profile
	User struct {
		// ID unique identity number
		ID UUID `json:"id,omitempty"`
		// User nickname or name
		Name string `json:"name"`
	}
)

// user endpoint
func (api *API) user(w http.ResponseWriter, r *http.Request) {
	defer r.Body.Close()
	switch r.Method {
	case "POST":
		var newUser User
		if err := json.NewDecoder(r.Body).Decode(&newUser); err != nil {
			api.ErrorResponse(w, fmt.Errorf("%s", "Invalid request payload"), http.StatusBadRequest)

			return
		}

		newUUID, err := generator.GenerateUUID()
		if err != nil {
			fmt.Fprint(w, err.Error())

			return
		}
		// Try save new user
		newUser.ID = UUID(newUUID)
		api.Storage.Add(newUUID, newUser)

		// TODO Refactor that, look to usersKey todo
		userCollection := api.Storage.Get(usersKey)
		if userCollection == nil {
			userCollection = make([]User, 0)
		}

		userCollection = append(userCollection.([]User), newUser)
		api.Storage.Add(usersKey, userCollection)

		api.SuccessResponse(w, http.StatusCreated, newUser)
	case "GET":
		var uCollection UserCollection

		uList := api.Storage.Get(usersKey)
		if uList != nil {
			uCollection.List = uList.([]User)
		}

		api.SuccessResponse(w, http.StatusOK, uCollection)
	default:
		api.InvalidHTTPMethod(w)
	}
}
