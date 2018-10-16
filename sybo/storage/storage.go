package storage

// Storage methods
type Storage interface {
	// Add to storage
	Add(key string, data interface{})
	// Get from storage
	Get(key string) interface{}
	// DeleteBy data by key
	DeleteBy(key string) bool
}
