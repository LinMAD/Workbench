package api

import (
	"encoding/json"
	"fmt"
	"github.com/LinMAD/workshops/sybo/storage"
	"log"
	"net/http"
)

const apiTag = "API"

type (
	// UUID represents type for unique id
	UUID string
	// API general structure
	API struct {
		Storage storage.Storage
	}
	// ErrorResponse default error response
	ErrorResponse struct {
		Message string `json:"error"`
	}
)

// NewAPI with simple DI
func NewAPI(storage storage.Storage) *API {
	return &API{
		Storage: storage,
	}
}

// ServeAllEndpoints handle all registered API endpoints
func (api *API) ServeAllEndpoints() {
	http.HandleFunc("/user", api.user)
}

// ErrorResponse
func (api *API) ErrorResponse(w http.ResponseWriter, err error, statusCode ...int) {
	var code int

	if len(statusCode) > 0 {
		code = statusCode[0]
	} else {
		code = http.StatusInternalServerError
	}

	w.WriteHeader(code)
	errResponse := ErrorResponse{Message: err.Error()}
	json.NewEncoder(w).Encode(errResponse)
}

// SuccessResponse
func (api *API) SuccessResponse(w http.ResponseWriter, code int, payload interface{}) {
	response, err := json.Marshal(payload)
	if err != nil {
		// TODO Use logger from dependencies
		log.Printf("%s%s", apiTag, err.Error())
		api.ErrorResponse(w, fmt.Errorf("%s", "Unable to dispatch response"))
		return
	}

	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(code)
	w.Write(response)
}
