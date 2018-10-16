package storage

import "testing"

func TestBoot(t *testing.T) {
	m := Boot()
	if m.bucket == nil {
		t.Error("memory bucket must be prepared")
	}
}

func TestMemoryStorage_Work(t *testing.T) {
	key := "unit"
	data := "hello world"

	m := Boot()
	m.Add(key, data)
	stored := m.Get(key)
	if stored == nil {
		t.Error("nil not expected from data storage")
	}
	if stored != data {
		t.Error("data from storage mutated")
	}
	if !m.DeleteBy(key) {
		t.Error("Expected true on delete event")
	}
	stored = m.Get(key)
	if stored != nil {
		t.Error("Expected to be nil, data must be deleted on key")
	}
}
