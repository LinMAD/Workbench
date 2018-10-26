package generator

import "testing"

func TestGenerateUUID(t *testing.T) {
	id1, errId1 := GenerateUUID()
	id2, errId2 := GenerateUUID()

	if errId1 != nil || errId2 != nil {
		t.Error("Unexpected error")
		t.Error(errId1.Error())
		t.Error(errId2.Error())
		t.Fail()
	}

	if id1 == id2 {
		t.Error("UUID must be unique, but they same")
	}
}
