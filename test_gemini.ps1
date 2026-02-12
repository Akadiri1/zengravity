$key = "AIzaSyCq4ttbKUNMWCPcL4RwfWZx8bVKkJbR6D0"
$models = @("gemini-1.5-flash", "gemini-1.5-flash-001", "gemini-1.5-pro", "gemini-pro-vision")

foreach ($model in $models) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/$($model):generateContent?key=$key"
    Write-Output "Testing Model: $model"
    
    $body = @{
        contents = @(
            @{
                parts = @(
                    @{ text = "Hello" }
                )
            }
        )
    } | ConvertTo-Json -Depth 5

    try {
        $response = Invoke-WebRequest -Uri $url -Method Post -Body $body -ContentType "application/json"
        Write-Output "SUCCESS: $model"
        # Write-Output $response.Content
    }
    catch {
        Write-Output "FAILED: $model"
        # Write-Output $_.Exception.Message
        if ($_.Exception.Response) {
            # Write-Output $_.Exception.Response.StatusCode
        }
    }
    Write-Output "--------------------------------"
}
