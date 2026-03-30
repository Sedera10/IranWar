<div class="contact-page">
    <h1>Contactez-nous</h1>
    
    <?php if ($success): ?>
        <div class="alert alert-success">
            Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <div class="contact-content">
        <div class="contact-form-section">
            <h2>Envoyez-nous un message</h2>
            
            <form action="<?= SITE_URL ?>/home/contact" method="POST" class="contact-form">
                <div class="form-group">
                    <label for="name">Nom complet *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Sujet</label>
                    <input type="text" id="subject" name="subject">
                </div>
                
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" rows="6" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Envoyer le message</button>
            </form>
        </div>
        
        <div class="contact-info-section">
            <h2>Informations de contact</h2>
            <ul>
                <li><strong>Email:</strong> contact@iranwar.info</li>
                <li><strong>Téléphone:</strong> +33 1 23 45 67 89</li>
                <li><strong>Adresse:</strong> Paris, France</li>
            </ul>
        </div>
    </div>
</div>
