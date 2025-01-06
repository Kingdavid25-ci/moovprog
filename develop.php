<!-- Section Développement des Performances -->
<div id="section4" class="section">
    <h2>Développement des Performances</h2>
    <form id="addDevelopmentQuestionForm" class="form-inline">
        <div class="form-group">
            <label>Question</label>
            <input type="text" id="developmentQuestion" class="form-control" placeholder="Entrez votre question">
        </div>
        <button type="button" class="btn btn-primary" onclick="addDevelopmentQuestion()">Ajouter Question</button>
    </form>
    <br>
    <table class="table table-bordered" id="developmentQuestionsTable">
        <thead>
            <tr>
                <th>ID Question</th>
                <th>Question</th>
                <th>Etat</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="navigation-buttons">
        <button class="btn btn-secondary" onclick="previousSection(3)">Back</button>
        <button class="btn btn-success" onclick="saveAll()">Enregistrer</button>
    </div>
</div>
