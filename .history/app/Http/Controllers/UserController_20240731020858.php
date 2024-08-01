public function updateUserInfo($id, Request $request)
{
    $account = Account::with('examinee')->find($id);

    if (!$account) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Validate the request data
    $validatedData = $request->validate([
        'Email' => 'email|unique:accounts,Email,' . $id . ',Id',
        'Phone' => 'nullable|string|max:20',
        'examinee.FullName' => 'string|max:255',
        'examinee.Birth' => 'date',
        'examinee.Gender' => 'in:M,F',
        'examinee.AddressDetail' => 'nullable|string|max:255',
        'examinee.GradeId' => 'exists:grades,Id',
    ]);

    DB::beginTransaction();

    try {
        // Update Account information
        $account->fill($request->only(['Email', 'Phone']));
        $account->save();

        // Update Examinee information
        if ($account->examinee) {
            $account->examinee->fill($request->input('examinee', []));
            $account->examinee->save();
        }

        DB::commit();

        return response()->json([
            'message' => 'User information updated successfully',
            'user' => $account->fresh('examinee')
        ], 200);

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error updating user information: ' . $e->getMessage());
        return response()->json(['message' => 'Error updating user information'], 500);
    }
}