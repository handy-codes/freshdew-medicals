# SFTP Deployment Setup Script for Hostinger
# This script automates the SSH key generation and setup process

Write-Host "SFTP Deployment Setup for Hostinger" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Step 1: Check for SSH tools
Write-Host "Step 1: Checking for SSH tools..." -ForegroundColor Yellow

$sshKeygenPath = Get-Command ssh-keygen -ErrorAction SilentlyContinue
$sshPath = Get-Command ssh -ErrorAction SilentlyContinue

if (-not $sshKeygenPath) {
    Write-Host "ssh-keygen not found!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Please install one of the following:" -ForegroundColor Yellow
    Write-Host "  1. Git for Windows (includes OpenSSH): https://git-scm.com/download/win" -ForegroundColor White
    Write-Host "  2. OpenSSH for Windows (Windows 10+):" -ForegroundColor White
    Write-Host "     Run: Add-WindowsCapability -Online -Name OpenSSH.Client~~~~0.0.1.0" -ForegroundColor White
    Write-Host ""
    Write-Host "After installation, restart PowerShell and run this script again." -ForegroundColor Yellow
    exit 1
}

Write-Host "SSH tools found!" -ForegroundColor Green
Write-Host ""

# Step 2: Create .ssh directory if it doesn't exist
Write-Host "Step 2: Setting up SSH directory..." -ForegroundColor Yellow

$sshDir = Join-Path $env:USERPROFILE ".ssh"
if (-not (Test-Path $sshDir)) {
    New-Item -ItemType Directory -Path $sshDir -Force | Out-Null
    Write-Host "Created .ssh directory: $sshDir" -ForegroundColor Green
} else {
    Write-Host ".ssh directory exists: $sshDir" -ForegroundColor Green
}
Write-Host ""

# Step 3: Generate SSH key pair
Write-Host "Step 3: Generating SSH key pair..." -ForegroundColor Yellow

$privateKeyPath = Join-Path $sshDir "hostinger_deploy"
$publicKeyPath = "$privateKeyPath.pub"

if (Test-Path $privateKeyPath) {
    Write-Host "SSH key already exists at: $privateKeyPath" -ForegroundColor Yellow
    $overwrite = Read-Host "Do you want to overwrite it? (y/N)"
    if ($overwrite -ne "y" -and $overwrite -ne "Y") {
        Write-Host "Skipping key generation. Using existing key." -ForegroundColor Yellow
    } else {
        Remove-Item $privateKeyPath -Force -ErrorAction SilentlyContinue
        Remove-Item $publicKeyPath -Force -ErrorAction SilentlyContinue
        Write-Host "Removed existing keys" -ForegroundColor Green
    }
}

if (-not (Test-Path $privateKeyPath)) {
    Write-Host "Generating new SSH key pair..." -ForegroundColor White
    Write-Host "Note: Press Enter twice when prompted for passphrase (leave it empty)" -ForegroundColor Yellow
    Write-Host ""
    
    # Generate SSH key (non-interactive)
    $keygenProcess = Start-Process -FilePath "ssh-keygen" -ArgumentList @(
        "-t", "rsa",
        "-b", "4096",
        "-C", "github-actions-deploy",
        "-f", $privateKeyPath,
        "-N", '""'  # Empty passphrase
    ) -Wait -NoNewWindow -PassThru
    
    if ($keygenProcess.ExitCode -eq 0) {
        Write-Host "SSH key pair generated successfully!" -ForegroundColor Green
    } else {
        Write-Host "Failed to generate SSH key pair" -ForegroundColor Red
        exit 1
    }
} else {
    Write-Host "Using existing SSH key pair" -ForegroundColor Green
}
Write-Host ""

# Step 4: Display public key
Write-Host "Step 4: Public Key (add this to Hostinger)" -ForegroundColor Yellow
Write-Host "==============================================" -ForegroundColor Yellow
Write-Host ""

if (Test-Path $publicKeyPath) {
    $publicKey = Get-Content $publicKeyPath -Raw
    Write-Host $publicKey -ForegroundColor White
    Write-Host ""
    Write-Host "Next Steps:" -ForegroundColor Cyan
    Write-Host "  1. Copy the public key above, it's already in your clipboard if possible" -ForegroundColor White
    Write-Host "  2. Log in to Hostinger hPanel" -ForegroundColor White
    Write-Host "  3. Go to: Advanced → SSH Access" -ForegroundColor White
    Write-Host "  4. Click: Add SSH Key" -ForegroundColor White
    Write-Host "  5. Paste the public key and save" -ForegroundColor White
    Write-Host ""
    
    # Try to copy to clipboard
    try {
        $publicKey | Set-Clipboard
        Write-Host "Public key copied to clipboard!" -ForegroundColor Green
    } catch {
        Write-Host "Could not copy to clipboard automatically" -ForegroundColor Yellow
    }
} else {
    Write-Host "Public key file not found: $publicKeyPath" -ForegroundColor Red
    exit 1
}
Write-Host ""

# Step 5: Display private key location
Write-Host "Step 5: Private Key Location" -ForegroundColor Yellow
Write-Host "=====================================" -ForegroundColor Yellow
Write-Host ""
Write-Host "Private key location: $privateKeyPath" -ForegroundColor White
Write-Host ""
Write-Host "SECURITY WARNING:" -ForegroundColor Red
Write-Host "   - Keep this private key SECRET!" -ForegroundColor Yellow
Write-Host "   - Never share it or commit it to Git!" -ForegroundColor Yellow
Write-Host "   - Only add it to GitHub Secrets" -ForegroundColor Yellow
Write-Host ""

# Step 6: Display private key content for GitHub Secrets
Write-Host "Step 6: Private Key Content (for GitHub Secrets)" -ForegroundColor Yellow
Write-Host "====================================================" -ForegroundColor Yellow
Write-Host ""
Write-Host "Copy the entire content below (including BEGIN and END lines) to GitHub Secrets:" -ForegroundColor White
Write-Host ""

if (Test-Path $privateKeyPath) {
    $privateKey = Get-Content $privateKeyPath -Raw
    Write-Host $privateKey -ForegroundColor White
    Write-Host ""
    
    # Try to copy to clipboard
    try {
        $privateKey | Set-Clipboard
        Write-Host "Private key copied to clipboard!" -ForegroundColor Green
    } catch {
        Write-Host "Could not copy to clipboard automatically" -ForegroundColor Yellow
    }
} else {
    Write-Host "Private key file not found: $privateKeyPath" -ForegroundColor Red
    exit 1
}
Write-Host ""

# Step 7: Instructions for GitHub Secrets
Write-Host "Step 7: Add GitHub Secrets" -ForegroundColor Yellow
Write-Host "==============================" -ForegroundColor Yellow
Write-Host ""
Write-Host "Go to your GitHub repository and add these secrets:" -ForegroundColor White
Write-Host ""
Write-Host "Repository → Settings → Secrets and variables → Actions → New repository secret" -ForegroundColor Cyan
Write-Host ""
Write-Host "Add these secrets:" -ForegroundColor White
Write-Host "  1. HOSTINGER_SSH_PRIVATE_KEY" -ForegroundColor Yellow
Write-Host "     Value: paste the private key from above" -ForegroundColor Gray
Write-Host ""
Write-Host "  2. HOSTINGER_SSH_HOST" -ForegroundColor Yellow
Write-Host "     Value: Your FTP server address, e.g., ftp.yourdomain.com" -ForegroundColor Gray
Write-Host ""
Write-Host "  3. HOSTINGER_SSH_USER" -ForegroundColor Yellow
Write-Host "     Value: Your FTP username, e.g., u123456789" -ForegroundColor Gray
Write-Host ""
Write-Host "  4. HOSTINGER_SSH_PORT" -ForegroundColor Yellow
Write-Host "     Value: 22 or your SSH port if different" -ForegroundColor Gray
Write-Host ""

# Step 8: Test SSH connection (optional)
Write-Host "Step 8: Test SSH Connection (Optional)" -ForegroundColor Yellow
Write-Host "=========================================" -ForegroundColor Yellow
Write-Host ""
$testConnection = Read-Host "Do you want to test the SSH connection now? (y/N)"
if ($testConnection -eq "y" -or $testConnection -eq "Y") {
    $sshHost = Read-Host "Enter SSH host, e.g., ftp.yourdomain.com or IP address"
    $sshUser = Read-Host "Enter SSH username"
    $sshPort = Read-Host "Enter SSH port, default is 22" 
    if ([string]::IsNullOrWhiteSpace($sshPort)) {
        $sshPort = "22"
    }
    
    Write-Host ""
    Write-Host "Testing SSH connection..." -ForegroundColor Yellow
    Write-Host "Command: ssh -i `"$privateKeyPath`" -p $sshPort $sshUser@$sshHost" -ForegroundColor Gray
    Write-Host ""
    
    # Test connection with timeout
    $testResult = & ssh -i $privateKeyPath -p $sshPort -o ConnectTimeout=10 -o StrictHostKeyChecking=no $sshUser@$sshHost "echo 'Connection successful!'" 2>&1
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "SSH connection successful!" -ForegroundColor Green
    } else {
        Write-Host "SSH connection failed" -ForegroundColor Red
        Write-Host "Error: $testResult" -ForegroundColor Red
        Write-Host ""
        Write-Host "Troubleshooting:" -ForegroundColor Yellow
        Write-Host "  - Verify SSH key is added to Hostinger" -ForegroundColor White
        Write-Host "  - Check SSH port (usually 22)" -ForegroundColor White
        Write-Host "  - Verify host and username are correct" -ForegroundColor White
    }
} else {
    Write-Host "Skipping SSH connection test." -ForegroundColor Gray
}
Write-Host ""

# Summary
Write-Host "Setup Complete!" -ForegroundColor Green
Write-Host "==================" -ForegroundColor Green
Write-Host ""
Write-Host "Summary of what was done:" -ForegroundColor Cyan
Write-Host "  SSH key pair generated" -ForegroundColor Green
Write-Host "  Public key displayed (add to Hostinger)" -ForegroundColor Green
Write-Host "  Private key displayed (add to GitHub Secrets)" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Cyan
Write-Host "  1. Add public key to Hostinger hPanel → Advanced → SSH Access" -ForegroundColor White
Write-Host "  2. Add private key and other secrets to GitHub" -ForegroundColor White
Write-Host "  3. Test the deployment workflow" -ForegroundColor White
Write-Host ""
Write-Host "Files created:" -ForegroundColor Cyan
Write-Host "  - Private key: $privateKeyPath" -ForegroundColor White
Write-Host "  - Public key: $publicKeyPath" -ForegroundColor White
Write-Host ""

