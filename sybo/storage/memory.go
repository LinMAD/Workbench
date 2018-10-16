package storage

import "sync"

// MemoryStorage temporary storage to keep some objects in memory
type MemoryStorage struct {
	bucket map[string]entity
	sync.RWMutex
}

// entity is a simple structure to keep data in memory
type entity struct {
	object interface{}
}

// Boot storage
func Boot() *MemoryStorage {
	return &MemoryStorage{
		bucket: make(map[string]entity),
	}
}

// Add data to storage
func (mc *MemoryStorage) Add(key string, data interface{}) {
	mc.Lock()
	if _, found := mc.bucket[key]; found {
		delete(mc.bucket, key)
	}
	mc.bucket[key] = entity{object: data}
	mc.Unlock()
}

// Get data by key
func (mc *MemoryStorage) Get(key string) interface{} {
	mc.RLock()

	// Get in bucket
	item, inStack := mc.bucket[key]
	if !inStack {
		mc.RUnlock()

		return nil
	}
	mc.RUnlock()

	return item.object
}

// DeleteBy data by key
func (mc *MemoryStorage) DeleteBy(key string) (isDeleted bool) {
	mc.Lock()
	isDeleted = mc.delete(key)
	mc.Unlock()
	return
}

func (mc *MemoryStorage) delete(key string) bool {
	if _, found := mc.bucket[key]; found {
		delete(mc.bucket, key)

		return true
	}

	return false
}
